import axios from 'axios'
import store from '@/store'

export const service = axios.create({
  baseURL: store.getters.getBaseUrl,
  headers: {
    'Content-Type': 'application/json'
  }
})

export const auth = axios.create({
  baseURL: `${store.getters.getBaseUrl}/auth`,
  headers: {
    'Content-Type': 'application/json'
  }
})
