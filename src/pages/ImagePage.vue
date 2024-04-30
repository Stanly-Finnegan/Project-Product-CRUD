<template>
  <q-layout>
    <div style="width: 100vw; min-height:100vh;" class="q-pa-xl column items-center">
        <h2 class="q-mb-xl text-center">Prduct Image Page</h2>

        <div class="row q-my-md justify-between" style="width:75%;">
          <h4 class="q-ma-none" >{{title}}</h4>
          <q-btn color="primary" icon="add" @click="btnInsertImage">Insert Product Image</q-btn>
        </div>
        <div class="row justify-center" style="width: 100%;">
            <q-card class="q-ma-sm q-pa-sm column col-3" v-for="item in data" :key="item">
            <q-img :src="imageSRC + item.image" :ratio="1"/>
            <!-- <img src="https://picsum.photos/500/300" alt=""> -->
            <q-card-actions>
              <q-btn  color="light-blue-10" :icon=" item.show? 'visibility' : 'visibility_off'" @click="btnShow(item)"/>
              <q-btn  color="red" icon="delete" @click="btnDelete(item)" />
            </q-card-actions>
          </q-card>
        </div>
    </div>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { api } from 'src/boot/axios.js'

const router = useRouter()
const route = useRoute()

const title = ref('')
const data = ref([])
const imageSRC = ref('http://localhost:8080/uploads/images/')

const paramData = ref(route.params.id)

const checkToken = () => {
  api.get('checkToken').then(() => {
  }).catch((err) => {
    console.log(err.response.status)
    router.push({ name: 'HomePage' })
  })
}
checkToken()

const getImageData = () => {
  api.get('getImageData/' + paramData.value, {
  }).then((response) => {
    console.log(response.data)
    title.value = response.data.title
    data.value = response.data.result
  })
}

getImageData()

const btnInsertImage = () => {
  router.push({ name: 'InsertImagePage' })
}

const btnShow = (data) => {
  api.put('changeImageShow', {
    id: data.id,
    show: !data.show
  }).then(() => {
    getImageData()
  })
}

const btnDelete = (data) => {
  api.delete('deleteProductImage/' + data.id)
    .then(() => {
      getImageData()
    }).catch((err) => {
      console.log(err)
    })
}
</script>
