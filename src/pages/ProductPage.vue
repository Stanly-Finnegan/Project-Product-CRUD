<template>
  <q-layout>
    <div style="width: calc(100dvw-var(--scrollbar-width)); min-height:100vh;" class="q-pa-xl ">
        <h3 class="q-mb-xl">Product Page</h3>
          <div class="row" >
            <q-card v-for="data in fetch" :key="data" class="q-pa-sm col-4 bg-transparent no-box-shadow" >
              <div class="q-pa-md" style="box-shadow: 7px 7px 26px #e6e6e6, 7px -7px 26px #ffffff;">
                <div class="text-weight-bold">
                  {{data.title}}
                  </div>
                <q-img class="q-mb-sm" :src="imageSRC + data.image" ratio="1"/>
                <div class="row ">
                  Rp.
                  <span class="q-mb-sm">{{ data.price}}</span>
                </div>
                <div class="q-gutter-y-sm">
                  <q-btn size="sm" color="blue-8" @click="btnView(data.id)" style="width: 100%;">view</q-btn>
                  <q-btn size="sm" color="green-8" @click="btnAddCart(data.id)" style="width: 100%;">Add to Cart</q-btn>
                </div>
              </div>
          </q-card>
        </div>
    </div>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { api } from 'src/boot/axios.js'
// import { route } from 'quasar/wrappers'

const router = useRouter()
const imageSRC = 'http://localhost:8080/uploads/images/'
const fetch = ref([])
// const isPwd = ref(true)

// const email = ref('')
// const password = ref('')

const getProduct = () => {
  api.get('getProductMemberData')
    .then((response) => {
      console.log(response.data)
      fetch.value = response.data
    })
}

getProduct()

// console.log(fetch.value)

const btnView = (data) => {
  router.push({ name: 'ProductDetailPage', params: { id: data } })
}

const btnAddCart = (data) => {
  api.post('addCartMemberItem', {
    id: data,
    quantity: 1
  }).then((response) => {
    router.push({ name: 'CartPage' })
  })
}

</script>
