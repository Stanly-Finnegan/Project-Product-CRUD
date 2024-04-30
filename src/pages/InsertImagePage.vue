<template>
  <q-layout>
    <div style="width: 100vw; height:100vh;" class="q-pa-xl column items-center">
        <h2 class="q-mb-xl text-center">Product Image Insert Page</h2>

        <q-form class=" q-gutter-y-md column items-center "  style="width: 50%;">
          <div style="width: 100%;">
            <h6 class="q-mb-sm">Images</h6>
            <q-file v-model="files" label="Pick files" filled multiple style="width: 100%;">
              <template v-slot:prepend>
                <q-icon name="upload" />
              </template>
            </q-file>
          </div>

          <div class="q-mt-xl" style="width: 100%;">
            <p class="q-ma-none">Show / Hide</p>
            <div class="q-gutter-x-sm" >
              <q-radio v-model="status" val="show" label="Show"></q-radio>
              <q-radio v-model="status" val="hide" label="Hide"></q-radio>
            </div>
          </div>

          <div class="q-mt-lg row q-gutter-x-md justify-end" style="width: 100%;">
            <q-btn rounded  label="Cancel" color="grey" @click.prevent="router.replace({name: 'ImagePage'})"/>
            <q-btn rounded  label="Insert" color="primary" type="submit"  @click="btnInsert"/>
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

const paramData = ref(route.params.id)
console.log(paramData.value)

const files = ref(null)

const checkToken = () => {
  api.get('checkToken').then(() => {
  }).catch((err) => {
    console.log(err.data.messages)
    router.push({ name: 'LoginPage' })
  })
}

checkToken()

const btnInsert = () => {
  api.post('insertImageProduct', {
    id: paramData.value,
    files: files.value,
    status: status.value
  }).then(() => {
    router.push({ name: 'ImagePage' })
  }).catch((err) => {
    console.log(err.data.messages)
  })
}

</script>
