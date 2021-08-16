import { AxiosStatic } from 'axios'
declare global {
    var axios: AxiosStatic
    interface Promise<T> {
        takeAtLeast(time: number): Promise<T>
    }
    interface PromiseConstructor {
        delay(time: number): Promise<T>
    }
    interface Window {
        rand(min: number, max: number): number
        axios: AxiosStatic
    }
}
