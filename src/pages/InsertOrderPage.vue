<template>
  <q-layout>
    <div style="width: 100vw; min-height:100vh;" class="q-pa-xl column items-center">
        <h2 class="q-mb-xl text-center">Order Insert Page</h2>

        <q-table
          :rows="rows"
          :columns="columns"
          row-key="title"
          title="Cart"
          style="width: 100%;"
        >
          <template v-slot:body-cell-delete="props">
            <q-td :props="props">
            <q-btn icon="delete" @click="deleteCart(props.pageIndex)"/>
           </q-td>
          </template>

          <template  v-slot:top-right>
            <div class="row q-gutter-x-md">
              <q-btn color="primary" label="Cancel" />
              <q-btn color="primary" label="Submit" @click="insertOrder"/>
            </div>
          </template>
        </q-table>

        <div class="row " style="width: 100%;">
          <h4>Total Price </h4>
          <h4 class="q-ml-xl">Rp. {{totalPrice}}</h4>
        </div>

        <div style="width: 100%;">
          <q-input v-model="search"  debounce="500" outlined style="width: 40%;" label="Search" >
            <template v-slot:prepend>
              <q-icon name="search" />
            </template>
          </q-input>
        </div>

        <div class="q-mt-xl q-gutter-y-md" style="width: 100%;">
          <q-card class=" q-pa-md" v-for="item in productData" :key="item">
            <q-card-section class="row justify-between items-center">
              <h5>{{ item.product.title }}</h5>
              <div class=" text-h5 row q-gutter-x-sm  items-center">
                Quantity :
                <q-input
                filled
                v-model = "item.quantity"
                type="number"
                />
              </div>
                <h5> Price Rp. {{ item.product.price }}</h5>
            </q-card-section>

            <q-card-section class="row q-gutter-md">
              <div  v-for="data in item.image" :key="data" style="width: 20%;">
                <q-img :src="imageSRC+data.image" ratio="1"/>
              </div>
            </q-card-section>

            <q-card-actions align="right">
              <q-btn @click="addCart(item)">
                add to cart
              </q-btn>
            </q-card-actions>
          </q-card>
        </div>

    </div>
  </q-layout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { api } from 'src/boot/axios.js'

const router = useRouter()

const columns = [
  { name: 'title', align: 'center', label: 'Title', field: 'title' },
  { name: 'quantity', align: 'center', label: 'Quantity', field: 'quantity' },
  { name: 'price', align: 'center', label: 'Price', field: 'price' },
  { name: 'totalPrice', align: 'center', label: 'Total Price', field: 'totalPrice' },
  { name: 'delete', align: 'center', label: 'Delete', field: 'delete' }
]

const rows = ref([])
const imageSRC = ref('http://localhost:8080/uploads/images/')
const productData = ref([])

const productCart = ref({
  title: '',
  id: '',
  quantity: 0,
  price: 0,
  totalPrice: 0
})

const search = ref('')

const getProductData = () => {
  api.get('getProductOrderData')
    .then((Response) => {
      productData.value = Response.data
    })
}

const getProductDataSearch = (data) => {
  api.get('getProductOrderData/' + data)
    .then((Response) => {
      productData.value = Response.data
    })
}
getProductData()

watch(() => search.value, (newVal) => {
  getProductDataSearch(newVal)
})

const checkToken = () => {
  api.get('checkToken').then(() => {
    rows.value = JSON.parse(localStorage.getItem('cart'))
  }).catch(() => {
    router.push({ name: 'LoginPage' })
  })
}

checkToken()

const addCart = (data) => {
  productCart.value.title = data.product.title
  productCart.value.price = data.product.price
  productCart.value.id = data.product.id
  productCart.value.quantity = data.quantity
  productCart.value.totalPrice = parseInt(data.product.price) * parseInt(data.quantity)

  rows.value = JSON.parse(localStorage.getItem('cart'))
  rows.value.push(productCart.value)

  localStorage.setItem('cart', JSON.stringify(rows.value))
  data.quantity = null
}

const deleteCart = (data) => {
  console.log(data)
  rows.value = JSON.parse(localStorage.getItem('cart'))

  // rows.value = rows.value.filter(item => item.title !== data.title && item.price !== data.price && item.quantity !== data.quantity && item.totalPrice !== data.totalPrice)

  rows.value.splice(data, 1)

  console.log(rows.value)
  localStorage.setItem('cart', JSON.stringify(rows.value))
}

const insertOrder = () => {
  rows.value = JSON.parse(localStorage.getItem('cart'))
  console.log(productCart.value)
  api.post('insertOrder', {
    data: rows.value,
    test: productCart.value
  }).then((Response) => {

  })
}

</script>
