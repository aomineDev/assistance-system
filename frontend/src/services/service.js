import axios from 'axios'
import store from '@/store'

const config = axios.create({
  baseURL: store.getters.getBaseUrl,
  headers: {
    'Content-Type': 'application/json'
  }
})

export default config
