export default class Model {
    #properties: (symbol | string)[]
    created_at: Date
    updated_at: Date

    static make(data: Object) {
        let model = new this()
        model.#setProperties(Reflect.ownKeys(model))
        model.fill(data)
        return model
    }

    fill(data: Object){
        this.#properties.forEach((key: any) => {
            this[key] = data[key] || null
        })

        return this
    }

    #setProperties(properties: (symbol | string)[]) {
        this.#properties = properties
    }

    getProperties() {
        return this.#properties
    }
}
