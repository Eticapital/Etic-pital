module.exports = {
  /**
     * Helper method for making POST HTTP requests.
     */
  post (uri, form) {
    return App.sendForm('post', uri, form)
  },

  /**
     * Helper method for making PUT HTTP requests.
     */
  put (uri, form) {
    return App.sendForm('put', uri, form)
  },

  /**
     * Helper method for making DELETE HTTP requests.
     */
  delete (uri, form) {
    return App.sendForm('delete', uri, form)
  },

  /**
     * Send the form to the back-end server.
     *
     * This function will clear old errors, update "busy" status, etc.
     */
  sendForm (method, uri, form) {
    return new Promise((resolve, reject) => {
      form.startProcessing()

      let formData = form.getData()
      axios[method](uri, formData)
        .then(response => {
          form.finishProcessing()
          resolve(response.data)
        })
        .catch(error => {
          form.busy = false
          if (error.response) {
            form.errors.set(error.response.data)
            reject(error.response.data)
            return
          }
          alert(error)
        })
    })
  }
}
