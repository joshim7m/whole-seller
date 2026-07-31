import { ref, watch } from 'vue'

const STORAGE_KEY = 'wishlist'

const ids = ref([])

function load() {
    try {
        const raw = localStorage.getItem(STORAGE_KEY)
        ids.value = raw ? JSON.parse(raw) : []
    } catch {
        ids.value = []
    }
}

function save() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(ids.value))
}

function toggle(productId) {
    const num = Number(productId)
    const idx = ids.value.indexOf(num)
    if (idx === -1) {
        ids.value.push(num)
    } else {
        ids.value.splice(idx, 1)
    }
    save()
}

function has(productId) {
    return ids.value.includes(Number(productId))
}

function count() {
    return ids.value.length
}

export function useWishlist() {
    return { ids, load, toggle, has, count }
}
