window.onload = function() {
    // Begin Swagger UI call region
    const ui = SwaggerUIBundle({
      url: "http://your-domain.com/api/v1/configs/set_swagger_config",
      dom_id: '#swagger-ui',
      validatorUrl: null,
      //docExpansion: 'none',
      presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIStandalonePreset
      ],
      plugins: [
        SwaggerUIBundle.plugins.DownloadUrl
      ],
      layout: "StandaloneLayout"
    })
    // End Swagger UI call region
    window.ui = ui
  }