const names = require('./4-names')
const sayHi = require('./5-utils')
const data = require('./6-alt-flavor')
require('./7-mind-grenade') //When you import a module(file) you invoke it also, because node wraps the code in a function when it exports it
console.log(data)
sayHi("Susan")
sayHi(names.john)
sayHi(names.peter)