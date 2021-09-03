let mapas = [];

function criarMapa(numeroMapa) {
    mapas[numeroMapa] = new Mapa(numeroMapa);
}

function obterMapa(numeroMapa) {
    return mapas[numeroMapa];
}

function buscaEnderecoFatura(cod_coleta,numeroMapa) {

    jQuery.ajax({
        type: "POST",
        url: "processos/CXESVEN001EDITARUC/CXESVEN001BUSCAENDERECOFATURA.php",
        data: { cod_coleta: cod_coleta },
        success: function (data) 
        {
            $("#enderecoFatura_" + numeroMapa).val(data);
            return false;
        }
    });

}

//////////////////////////////////////////////////////////////////////////////////////////

class Mapa {
    constructor(numeroMapa, selecionarPosicaoAtual = true) {
        this.numeroMapa = numeroMapa;
        this.marcadores = [];
        this.mapa;

        const myLatlng = {
            lat: -26.50104720746333,
            lng: -49.082455278733455
        };

        let frameMapa = document.getElementById("googleMap_" + this.numeroMapa);
        this.mapa = new google.maps.Map(frameMapa, {
            zoom: 18,
            center: myLatlng,
            mapTypeId: 'satellite',
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: true,
            streetViewControl: false,
            rotateControl: true,
            fullscreenControl: false,
            options: {
                gestureHandling: 'greedy'
            }
        });

        this.mapa.addListener("click", (mapsMouseEvent) => {
            this.selectLocation(mapsMouseEvent.latLng);
        });

        this.loadAutocomplete();
        this.addHandleToButtons();

        if (selecionarPosicaoAtual == true) {
            setTimeout(() => {
                this.selecionarPosicaoAtual();
            }, 1000);
        }
    }



    addHandleToButtons() {
        let numeroMapa = this.numeroMapa;

        let btnLocalizacao = document.getElementById('btnLocalizacao_' + numeroMapa);
        if (btnLocalizacao != null) {
            btnLocalizacao.addEventListener('click', function () {
                mapas[numeroMapa].selecionarPosicaoAtual();
            });
        }

        let btnLocalizacaoCliente = document.getElementById('btnLocalizacaoCliente_' + numeroMapa);
        if (btnLocalizacaoCliente != null) {
            btnLocalizacaoCliente.addEventListener('click', function () {
                var latitude = parseFloat($("#latitude_origem").val());
                var longitude = parseFloat($("#longitude_origem").val());

                var latLong = {
                    lat: latitude,
                    lng: longitude,
                };

                var mapa = mapas[numeroMapa];

                mapa.cleanMarkers();
                mapa.searchLocation(latLong);
            });
        }

        let btnLocalizacaoColetada = document.getElementById('btnLocalizacaoColetada_' + numeroMapa);
        if (btnLocalizacaoColetada != null) {
            btnLocalizacaoColetada.addEventListener('click', function () {
                var mapa = mapas[numeroMapa];

                mapa.cleanMarkers();
                mapa.searchLocation(coords);

                var cod_coleta = $("#cod_coleta").val();
                buscaEnderecoFatura(cod_coleta,numeroMapa);


                if (coordsAux1['lat'] != '')
                    mapa.selectLocation(new google.maps.LatLng(coordsAux1['lat'], coordsAux1['lng']));
                if (coordsAux2['lat'] != '')
                    mapa.selectLocation(new google.maps.LatLng(coordsAux2['lat'], coordsAux2['lng']));
            });
        }

        let btnLimparMarcadores = document.getElementById('btnLimparMarcadores_' + numeroMapa);
        if (btnLimparMarcadores != null) {
            btnLimparMarcadores.addEventListener('click', function () {
                mapas[numeroMapa].cleanMarkers();
            });
        }
    }

    loadAutocomplete() {
        const input = document.getElementById("endereco_" + this.numeroMapa);
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo("bounds", this.mapa);
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            this.cleanMarkers();

            this.mapa.setZoom(18);
            this.searchLocation(place.geometry.location.toJSON());

            if (place.address_components) {
                address = [
                (place.address_components[0] &&
                    place.address_components[0].short_name) ||
                "",
                (place.address_components[1] &&
                    place.address_components[1].short_name) ||
                "",
                (place.address_components[2] &&
                    place.address_components[2].short_name) ||
                "",
                ].join(" ");
            }
        });
    }

    setCurrentPosition(posicao) {
        var latLong = {
            lat: posicao.coords.latitude,
            lng: posicao.coords.longitude,
        };

        this.cleanMarkers();
        this.searchLocation(latLong);
    }

    searchLocation(latLong) {
        this.mapa.setCenter(latLong);
        this.selectLocation(new google.maps.LatLng(latLong['lat'], latLong['lng']));
    }

    selectLocation(latLong) {
        const quantidadeMaximaDeMarcadores = 3;
        let coords = latLong.toJSON();
        let quantidadeAtualDeMarcadores = this.marcadores.length;

        let indexDoMarcador = quantidadeAtualDeMarcadores;
        let marcador = null;

        if (quantidadeAtualDeMarcadores >= quantidadeMaximaDeMarcadores) {
            return false;
        }

        let nomeDoMarcador = 'marcador' + (indexDoMarcador + 1);
        let icone =
        indexDoMarcador == 0
        ?
        'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAALiIAAC4iAari3ZIAAAYNaVRYdFhNTDpjb20uYWRvYmUueG1wAAAAAAA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pg0KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyI+DQogIDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+DQogICAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczpJcHRjNHhtcENvcmU9Imh0dHA6Ly9pcHRjLm9yZy9zdGQvSXB0YzR4bXBDb3JlLzEuMC94bWxucy8iIHhtbG5zOkdldHR5SW1hZ2VzR0lGVD0iaHR0cDovL3htcC5nZXR0eWltYWdlcy5jb20vZ2lmdC8xLjAvIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOnBsdXM9Imh0dHA6Ly9ucy51c2VwbHVzLm9yZy9sZGYveG1wLzEuMC8iIHhtbG5zOmlwdGNFeHQ9Imh0dHA6Ly9pcHRjLm9yZy9zdGQvSXB0YzR4bXBFeHQvMjAwOC0wMi0yOS8iIHhtbG5zOnhtcFJpZ2h0cz0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3JpZ2h0cy8iIHBob3Rvc2hvcDpDcmVkaXQ9IkdldHR5IEltYWdlcy9pU3RvY2twaG90byIgR2V0dHlJbWFnZXNHSUZUOkFzc2V0SUQ9IjEwMjE2NDExNTgiIHhtcFJpZ2h0czpXZWJTdGF0ZW1lbnQ9Imh0dHBzOi8vd3d3LmlzdG9ja3Bob3RvLmNvbS9sZWdhbC9saWNlbnNlLWFncmVlbWVudD91dG1fbWVkaXVtPW9yZ2FuaWMmYW1wO3V0bV9zb3VyY2U9Z29vZ2xlJmFtcDt1dG1f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'
        :
        'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAALiIAAC4iAari3ZIAAAYNaVRYdFhNTDpjb20uYWRvYmUueG1wAAAAAAA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pg0KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyI+DQogIDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+DQogICAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczpJcHRjNHhtcENvcmU9Imh0dHA6Ly9pcHRjLm9yZy9zdGQvSXB0YzR4bXBDb3JlLzEuMC94bWxucy8iIHhtbG5zOkdldHR5SW1hZ2VzR0lGVD0iaHR0cDovL3htcC5nZXR0eWltYWdlcy5jb20vZ2lmdC8xLjAvIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOnBsdXM9Imh0dHA6Ly9ucy51c2VwbHVzLm9yZy9sZGYveG1wLzEuMC8iIHhtbG5zOmlwdGNFeHQ9Imh0dHA6Ly9pcHRjLm9yZy9zdGQvSXB0YzR4bXBFeHQvMjAwOC0wMi0yOS8iIHhtbG5zOnhtcFJpZ2h0cz0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3JpZ2h0cy8iIHBob3Rvc2hvcDpDcmVkaXQ9IkdldHR5IEltYWdlcy9pU3RvY2twaG90byIgR2V0dHlJbWFnZXNHSUZUOkFzc2V0SUQ9IjEwMjE2NDExNTgiIHhtcFJpZ2h0czpXZWJTdGF0ZW1lbnQ9Imh0dHBzOi8vd3d3LmlzdG9ja3Bob3RvLmNvbS9sZWdhbC9saWNlbnNlLWFncmVlbWVudD91dG1fbWVkaXVtPW9yZ2FuaWMmYW1wO3V0bV9zb3VyY2U9Z29vZ2xlJmFtcDt1dG1f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';

        marcador = new google.maps.Marker({
            position: latLong,
            title: nomeDoMarcador,
            icon: icone
        });
        marcador.setMap(this.mapa);
        this.marcadores[indexDoMarcador] =
        {
            'marcador': marcador,
            'coordenadas': coords
        }

        if (indexDoMarcador == 0) {
            this.setValorCampo('latitude_' + this.numeroMapa, coords['lat']);
            this.setValorCampo('longitude_' + this.numeroMapa, coords['lng']);

            var numeroMapa = this.numeroMapa;

            jQuery.ajax({
                type: "POST",
                url: "processos/CXESVEN001/CXESVEN001BUSCAENDERECOMAPA.php",
                data: { latitude: coords['lat'], longitude: coords['lng'] },
                success: function (data) 
                {
                    $("#endereco_" + numeroMapa).val(data);
                    var edicao = $("#editar_uc").val();

                    if(edicao == 0)
                    {
                       $("#enderecoFatura_" + numeroMapa).val(data); 
                    }
                    else
                    {
                        var cod_coleta = $("#cod_coleta").val();
                        buscaEnderecoFatura(cod_coleta,numeroMapa)
                    }

                    return false;
            }
        });
        }
        else {
            this.setValorCampo('latitude_' + this.numeroMapa + '_aux' + indexDoMarcador, coords['lat']);
            this.setValorCampo('longitude_' + this.numeroMapa + '_aux' + indexDoMarcador, coords['lng']);
        }
    }

    setValorCampo(idCampo, valor) {
        var campo = document.getElementById(idCampo);
        if (campo != null)
            campo.value = valor;
    }

    cleanMarkers(limparEnderecoFatura) {
        this.marcadores.forEach((item) => {
            item.marcador.setMap(null);
        });
        this.marcadores = [];

        $('.campoCoordenada').val('');
        $("#endereco_" + this.numeroMapa).val('');
        $("#enderecoFatura_" + this.numeroMapa).val('');
    }

    selecionarPosicaoAtual() {
        let callback = (posicao) => {
            this.setCurrentPosition(posicao);
        }

        navigator.geolocation.getCurrentPosition(callback);
    }

    obterMarcadores() {
        return this.marcadores;
    }
}