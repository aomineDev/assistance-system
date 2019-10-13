const formatDate = {}

function formatingDate (date) {
  return date.split('-').reverse().join('/')
}

formatDate.install = function (Vue) {
  Vue.filter('formatDate', val => formatingDate(val))
}

export default formatDate
