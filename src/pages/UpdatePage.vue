<template>
  <q-layout>
    <div style="width: 100vw; height:100vh;" class="q-pa-xl column items-center">
        <h2 class="q-mb-xl text-center">Product Update Page</h2>

        <q-form class=" q-gutter-y-md column items-center "  style="width: 50%;">
          <q-input v-model="title" outlined label="Title" placeholder="Title"  class=""  style="width: 100%;"></q-input>
          <q-input v-model="description" type="textarea" outlined label="Description" placeholder="Description" class="" style="width: 100%;" ></q-input>
          <q-input v-model="price" outlined label="Price" placeholder="Price"  class=""  style="width: 100%;"></q-input>

          <div class="q-mt-xl" style="width: 100%;">
            <p class="q-ma-none">Show / Hide</p>
            <div class="q-gutter-x-sm" >
              <q-radio v-model="status" val="show" label="Show"></q-radio>
              <q-radio v-model="status" val="hide" label="Hide"></q-radio>
            </div>
          </div>

          <div class="q-mt-lg row q-gutter-x-md justify-end" style="width: 100%;">
            <q-btn rounded  label="Cancel" color="grey" @click.prevent="router.replace({name: 'HomePage'})"/>
            <q-btn rounded  label="Update" color="primary" type="submit"  @click="btnUpdate"/>
          </div>
        </q-form>

    </div>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { api } from 'src/boot/axios.js'
const router = useRouter()
const route = useRoute()
const status = ref('')

const title = ref('')
const description = ref('')
const price = ref('')
const paramData = ref(route.params.id)

const checkToken = () => {
  api.get('checkToken').then(() => {
  }).catch(() => {
    router.push('/')
  })
}

checkToken()

console.log(paramData.value)
// Get data by id
const getUpdateData = () => {
  api.get('getUpdateData/' + paramData.value, {
  }).then((response) => {
    // console.log(response.data)
    title.value = response.data.title
    description.value = response.data.description
    price.value = response.data.price
    status.value = response.data.status
  })
}

getUpdateData()

const btnUpdate = () => {
  console.log(title.value)
  api.put('updateProduct', {
    title: title.value,
    description: description.value,
    price: price.value,
    status: status.value,
    id: paramData.value
  }).then(() => {
    router.push({ name: 'HomePage' })
  }).catch((err) => {
    console.log(err)
  })
}

</script>
