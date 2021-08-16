import '../css/app.css'
import {createApp, h} from 'vue'
import App from './App.vue'
import AppRouter from './router'
import AppStore from './store'

const app = createApp({
    render() {
        return h(App)
    },
})


app.use(AppRouter)
app.use(AppStore)

app.mount('#app')
