import {getAccessor} from './modelHelpers'
import { format } from 'date-fns'

export default class Model {
    static properties: string[] = []
    static relationships: string[] = []

    created_at: string | number | Date
    updated_at: string | number | Date

    constructor(data: object) {
        let model = this.fill(data)

        return new Proxy(model, {
            get(target: any, prop: string, receiver: any){
                if (prop){
                    if (prop in target) {
                        return target[prop]
                    }
                    if (getAccessor(target, prop)) {
                        return getAccessor(target, prop)
                    }
                }
            }
        })
    }

    fill(data: object){
        this.constructor.properties.forEach(key => {
            this[key] = data[key] || null
        })

        return this
    }

    createdAt(f = '') {
        return format(new Date(this.created_at), f)
    }
}
