// Matheus Pollauf da Silva - 09/07/2021

class DynaInputMaxMinVal {
    constructor(options =
        {
            className: 'dynaInputMaxMinVal',
            max: '100',
            min: '0',
            zero: '0,00',
            filter: (value) => DynaInputFormat.formatStringToFloat(value),
        }) {
        this.element = document.querySelector(options.el);
        this.build(options);
    }

    build(options) {
        let max = parseFloat(options.max);
        let min = parseFloat(options.min);

        let inputs = document.getElementsByClassName(options.className);

        for (let i = 0; i < inputs.length; i++) {
            let input = inputs[i];
            input.addEventListener('keyup', () => {
                setTimeout(() => {
                    let value = 'filter' in options ? options.filter(input.value) : input.value;

                    if (value < min || value > max) {
                        let zero = 'zero' in options ? options.zero : '';
                        input.value = zero;

                        input.style.backgroundColor = '#ffcccb';

                        setTimeout(() => {
                            $(input).css('background-color', '');
                        }, 1000);
                    }
                }, 100);
            }, false);
        }
    }
}

class DynaInputFormat {
    static formatStringToFloat(value, options = { originalDecPoint: ',', originalThousandsSep: '.' }) {
        let formated = value.toString();

        formated = formated.replaceAll(options.originalThousandsSep, '');
        formated = formated.replaceAll(options.originalDecPoint, '.');

        return parseFloat(formated);
    }
}