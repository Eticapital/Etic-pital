/**
 * SparkForm helper class. Used to set common properties on all forms.
 */
window.Form = function (data) {
    var form = this;

    $.extend(this, data);

    this.originalData = data;

    /**
     * Create the form error helper instance.
     */
    this.errors = new FormErrors();

    this.busy = false;
    this.successful = false;

    /**
     * Start processing the form.
     */
    this.startProcessing = function () {
        form.errors.forget();
        form.busy = true;
        form.successful = false;
    };

    /**
     * Finish processing the form.
     */
    this.finishProcessing = function () {
        form.busy = false;
        form.successful = true;
    };

    /**
     * Reset the errors and other state for the form.
     */
    this.resetStatus = function () {
        form.errors.forget();
        form.busy = false;
        form.successful = false;
    },


    /**
     * Set the errors on the form.
     */
    this.setErrors = function (errors) {
        form.busy = false;
        form.errors.set(errors);
    }

    /**
     * Returns only the oriignal attributes
     */
    this.getData = function () {
        // Creo el objeto con los datos originales
        let data = _.mapValues(this.originalData, (value, key) => {
            return this[key];
        });

        return data;
    }

    /**
     * Allows to override the values from an object
     *
     */
    this.appendModel = function(model)
    {
        Object.keys(model).forEach(function (key) {
            this[key] = model[key];
        }.bind(this));
    }

    /**
     * Allows to override the values from an object
     *
     */
    this.reset = function()
    {
        Object.keys(this.originalData).forEach(function (key) {
            this[key] = this.originalData[key];
        }.bind(this));
    }
};
