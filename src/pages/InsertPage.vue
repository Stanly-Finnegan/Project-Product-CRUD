<template>
  <q-layout>
    <div style="width: 100vw; min-height:100vh;" class="q-pa-xl column items-center">
        <h2 class="q-mb-xl text-center">Product Insert Page</h2>

        <q-form class=" q-gutter-y-md column items-center "  style="width: 50%;">
          <q-input v-model="title" outlined label="Title" placeholder="Title"  class=""  style="width: 100%;"></q-input>
          <q-input v-model="description" type="textarea" outlined label="Description" placeholder="Description" class="" style="width: 100%;" ></q-input>
          <q-input v-model="price" type="number" outlined label="Price" placeholder="Price"  class=""  style="width: 100%;"></q-input>

          <div class="q-mt-xl" style="width: 100%;">
            <p class="q-ma-none">Show / Hide</p>
            <div class="q-gutter-x-sm" >
              <q-radio v-model="status" val="show" label="Show"></q-radio>
              <q-radio v-model="status" val="hide" label="Hide"></q-radio>
            </div>
          </div>

          <div class="q-mt-lg row q-gutter-x-md justify-end" style="width: 100%;">
            <q-btn rounded  label="Cancel" color="grey" @click.prevent="router.push('home')"/>
            <q-btn rounded  label="Insert" color="primary" type="submit"  @click="btnInsert"/>
          </div>
        </q-form>

    </div>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { api } from 'src/boot/axios.js'

const router = useRouter()
const status = ref('')

const title = ref('')
const description = ref('')
const price = ref('')

const checkToken = () => {
  api.get('checkToken').then(() => {
  }).catch(() => {
    router.push({ name: 'LoginPage' })
  })
}

checkToken()

const btnInsert = () => {
  api.post('insertProduct', {
    title: title.value,
    description: description.value,
    price: price.value,
    status: status.value
  }).then(() => {
    router.push({ name: 'ProductPage' })
  }).catch((err) => {
    console.log(err)
  })
}

</script>
