!function(a,b,c,d){function e(a,b){var c={};for(var d in b)"[object Array]"===Object.prototype.toString.call(b[d])?c[d]=a[d].slice():"object"==typeof b[d]?(a[d]||(a[d]={}),c[d]=e(a[d],b[d])):b[d]!=a[d]&&(c[d]=a[d]);return c}function f(a){var b=d;if("[object Array]"===Object.prototype.toString.call(a)&&(b=0==a.length?d:a.slice()),"object"==typeof a)if(g(a))b=d;else for(var c in a){var e=f(a[c]);e!==d&&(b===d&&(b={}),b[c]=e)}else b=a;return b}function g(a){for(var b in a)if(a.hasOwnProperty(b))return!1;return JSON.stringify(a)===JSON.stringify({})}a.wcpCompress=function(b,c){objCopy=a.extend(!0,{},b),defaultsCopy=a.extend(!0,{},c);var d=e(objCopy,defaultsCopy),g=f(d);return g}}(jQuery,window,document);