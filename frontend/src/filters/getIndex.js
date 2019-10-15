const getIndex = {}

function toIndex (value) {
  return ++value
}

getIndex.install = function (Vue) {
  Vue.filter('getIndex', val => toIndex(val))
}

export default getIndex
