function Tools() {
}

Tools.prototype.sum = function(a, b) {
    return a + b;
}

Tools.prototype.eval = function(code) {
    return eval(code);
}

Tools.prototype.removeWWW = function(domain) {
    return domain.replace(/^www\./i, '');
}

new Tools; //return Tools object