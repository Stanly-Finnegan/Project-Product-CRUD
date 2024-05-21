<template>
  <q-layout>
    <div style="width: calc(100dvw-var(--scrollbar-width)); min-height:100vh;" class="q-pa-xl ">
        <h2 class="q-mb-xl">Product Detail Page</h2>
        <div >
          <div>
            <h4 >{{fetchDetail.title}}</h4>
          </div>

          <div class="q-my-lg text-body1" >
            {{fetchDetail.description}}
          </div>

          <div class="row q-pb-xl">
            <div class="col-6 q-px-md">
                <div class="q-pa-sm rounded-borders" style="box-shadow: 7px 7px 26px #e6e6e6, 7px -7px 26px #ffffff;">
                  <q-img :src="imageSRC + fetchDetail.highlight" ratio="1"/>
                </div>
                <div>
                  <div class="row">
                    <div v-for="data in fetchDetail.image" :key="data" class="q-ma-sm bg-transparent col-3">
                      <div class="q-pa-sm rounded-borders" style="box-shadow: 7px 7px 26px #e6e6e6, 7px -7px 26px #ffffff;">
                        <q-img :src="imageSRC + data" ratio="1"/>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col-6 q-px-md">
              <div >
                <h5 class="q-my-md text-bold">Quantity</h5>
              </div>
              <div class="row">
                <div class="col-6">
                  <q-input v-model="quantity" type="number" outlined style="width: 80%;"/>
                </div>
                <div class="col-6 row text-h6 items-center">
                  Rp.
                  <span>
                    {{fetchDetail.price}}
                  </span>
                </div>
              </div>
              <div class="q-my-md">
                <q-btn color="primary" @click="btnAddCart">add to cart</q-btn>
              </div>
            </div>
          </div>

          <div>
            <div>
              <h5 class="q-my-md text-bold">Other Product</h5>
            </div>
            <div class="row" >
            <q-card v-for="data in filteredProduct" :key="data" class="q-pa-sm col-2 bg-transparent no-box-shadow" >
              <div class="q-pa-md" style="box-shadow: 7px 7px 26px #e6e6e6, 7px -7px 26px #ffffff;">
                <div class="text-weight-bold">
                  {{data.title}}
                  </div>
                <q-img class="q-mb-sm" :src="imageSRC + data.image" ratio="1"/>
                <div class="row q-mb-sm">
                  Rp.
                  <span class="">{{ data.price}}</span>
                </div>
                <div class="q-gutter-y-sm">
                  <q-btn size="sm" color="blue-8" @click="btnView(data.id)" style="width: 100%;">view</q-btn>
                </div>
              </div>
          </q-card>
        </div>
          </div>

        </div>
    </div>
  </q-layout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { api } from 'src/boot/axios.js'

const router = useRouter()
const route = useRoute()
const imageSRC = 'http://localhost:8080/uploads/images/'
const fetchDetail = ref([])
const fetchProduct = ref([])
const filteredProduct = ref([])
const quantity = ref(1)

const getProduct = () => {
  api.get('getProductMemberDetailData/' + route.params.id)
    .then((response) => {
      console.log(response.data)
      fetchDetail.value = response.data
    })
}
getProduct()

const getOtherProduct = () => {
  api.get('getProductMemberData')
    .then((response) => {
      fetchProduct.value = response.data
      filteredProduct.value = fetchProduct.value.filter((item) => item.id !== route.params.id)
      console.log('before' + fetchProduct.value)
      console.log('filtered' + filteredProduct.value)
    })
}

getOtherProduct()

watch(() => route.params.id, (newVal) => {
  getProduct()
  getOtherProduct()
})

const btnView = (data) => {
  router.push({ name: 'ProductDetailPage', params: { id: data } })
}

const btnAddCart = () => {
  api.post('addCartMemberItem', {
    id: route.params.id,
    quantity: quantity.value
  }).then((response) => {
    router.push({ name: 'CartPage' })
  })
}

</script>
