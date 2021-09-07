<script src="js/loadModal.js"></script>

<div class="modal fade" id="ModalConfirmar" style="z-index: 999999999" role="dialog" data-backdrop="static">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> <span id="titulo_header"></span></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_confirmar" id="id_confirmar" />
                <input type="hidden" name="status_confirmar" id="status_confirmar" />
                <input type="hidden" name="partida_confirmar" id="partida_confirmar" />

                <span id="texto_body"></span>
                <br>
                <div id="dados_confirmar"></div>

                <center><img src="assets/images/gif/aguarde.gif" style="width: 150px; height: 150px; display: none;"
                        id="aguarde_confirmar" /></center>
                <div class="alert alert-danger" role="alert" id="erro_confirmar" style="display:none;">
                    <center><b> Erro ao alterar. Contate o Suporte!</b></center>
                </div>
                <div class="alert alert-success" role="alert" id="sucesso_confirmar" style="display:none;">
                    <center><b> Alterado com Sucesso!</b></center>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-remove"
                        aria-hidden="true"></i></button>
                <button type="button" id="confirma_confirmar" class="btn btn-success">Confirmar <i class="fa fa-check"
                        aria-hidden="true"></i></button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="ModalAguarde" style="z-index: 9999" role="dialog" data-backdrop="static">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Aguarde... <span id="nro_os_status"></span></h4>
            </div>
            <div class="modal-body">

                <center><img src="assets/images/gif/aguarde.gif" style="width: 150px; height: 150px;" /></center>
            </div>
            <div class="modal-footer">

            </div>
        </div>

    </div>
</div>