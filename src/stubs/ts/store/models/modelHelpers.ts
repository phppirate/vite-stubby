function getAllFuncs(toCheck: any) {
    var props: string[] = [];
    var obj: object = toCheck;
    do {
        props = props.concat(Object.getOwnPropertyNames(obj));
    } while (obj = Object.getPrototypeOf(obj));

    return props.sort().filter(function(e, i, arr) { 
       if (e!=arr[i+1] && typeof toCheck[e] == 'function') return true;
       return false
    });
}

function hasMethod(target: object, method: string) {
    return !! getAllFuncs(target).find(f => f == method)
}


export function getAccessor(target, prop) {
    if (typeof(prop) == 'string') {
        let methodName = _.camelCase(`get ${prop} attribute`)
        if (hasMethod(target, methodName)) {
            return target[methodName]()
        }
    }

    return false
}
