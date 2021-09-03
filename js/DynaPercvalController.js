class DynaPercvalController {
    elements = [];
    baseval = 0;
    delay = 0;
    dfmt = null;
    fmt = null;
    nextFunction = () => { };

    // { el_perc, el_val }
    constructor(elements, baseval) {
        this.elements = elements;
        this.baseval = baseval;

        this.dfmt = (value) => {
            if (value == null || value == undefined || value == '')
                return 0;

            let fmtValue = value.replaceAll('.', '');
            fmtValue = fmtValue.replaceAll(',', '.');

            fmtValue = parseFloat(fmtValue);

            return fmtValue;
        };

        this.fmt = (value) => {
            if (value == null || value == undefined || value == '')
                return '0,00';

            let formatter =
                new Intl.NumberFormat('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

            let reformatado = formatter.format(value);

            return reformatado;
        };
    }

    setDelay(delay) {
        this.delay = delay;
    }

    setNextFunction(nextFunction) {
        this.nextFunction = nextFunction;
    }

    build() {
        for (let elidx in this.elements) {
            let element = this.elements[elidx];
            element.el_perc = document.querySelector(element.el_perc);
            element.el_val = document.querySelector(element.el_val);

            if (element.el_perc == null || element.el_val == null) {
                continue;
            }

            element.el_perc.addEventListener('keyup', () => {
                if (element.el_perc.readOnly)
                    return;

                setTimeout(() => {
                    let val = this.baseval * (parseInt(this.dfmt(element.el_perc.value)) / 100);
                    element.el_val.value = this.fmt(val);

                    this.nextFunction();
                }, this.delay);
            });

            element.el_val.addEventListener('keyup', () => {
                if (element.el_val.readOnly)
                    return;

                setTimeout(() => {
                    let val = (this.dfmt(element.el_val.value) / this.baseval) * 100;
                    element.el_perc.value = this.fmt(val);

                    this.nextFunction();
                }, this.delay);
            });
        }
    }

    updateAllPercs() {
        for (let elidx in this.elements) {
            let element = this.elements[elidx];

            if (element.el_perc == null || element.el_val == null) {
                continue;
            }

            let val = (this.dfmt(element.el_val.value) / this.baseval) * 100;
            element.el_perc.value = this.fmt(val);
        }

        this.nextFunction();
    }

    updateAllVals() {
        for (let elidx in this.elements) {
            let element = this.elements[elidx];

            if (element.el_perc == null || element.el_val == null) {
                continue;
            }

            let val = this.baseval * (parseInt(this.dfmt(element.el_perc.value)) / 100);
            element.el_val.value = this.fmt(val);
        }

        this.nextFunction();
    }
}