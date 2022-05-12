import directives from 'src/directives'

export default ({ app }) => {
  directives.forEach(directive => {
    app.directive(directive.name, directive)
  })
}
