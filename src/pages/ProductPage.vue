<template>
  <div class="q-pa-md">
    <h1>Product Page</h1>

    <q-table
      :rows="rows"
      :columns="columns"
      row-key="product_title"
    >
    <template v-slot:body-cell-action="props">
      <q-td :props="props">
        <q-btn-dropdown color="primary">
          <q-list>
            <q-item clickable v-close-popup @click="btnImage(props.row)">
              <q-item-section>
                <q-item-label>
                  Images
                </q-item-label>
              </q-item-section>
            </q-item>

            <q-item clickable v-close-popup @click="btnUpdate(props.row)">
              <q-item-section>
                <q-item-label>
                  Update
                </q-item-label>
              </q-item-section>
            </q-item>

            <q-item clickable v-close-popup @click="btnShow(props.row)">
              <q-item-section>
                <q-item-label>
                  Show / Hide
                </q-item-label>
              </q-item-section>
            </q-item>

            <q-item clickable v-close-popup @click="btnDelete(props.row)">
              <q-item-section>
                <q-item-label>
                  Delete
                </q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-btn-dropdown>
      </q-td>
    </template>

    <template v-slot:top-right>
        <q-btn color="primary" label="Insert" @click="btnInsert"/>
    </template>
  </q-table>

  </div>
</template>

<script setup>
import { api } from 'src/boot/axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const rows = ref([])

const columns = [
  { name: 'title', align: 'center', label: 'Title', field: 'title' },
  { name: 'price', align: 'center', label: 'Price', field: 'price' },
  { name: 'status', align: 'center', label: 'Show/Hide', field: 'status' },
  { name: 'action', align: 'center', field: 'action', label: 'Action' }
]

const getProduct = () => {
  api.get('getProduct')
    .then((response) => {
      console.log(response.data)
      rows.value = response.data
    }).catch((err) => {
      console.log(err)
    })
}

getProduct()

const btnInsert = () => {
  api.get('checkToken')
    .then(() => {
      router.push({ name: 'InsertProductPage' })
    }).catch((err) => {
      console.log(err.response.data.messages)
    })
}

const btnShow = (data) => {
  api.put('changeShow', {
    id: data.id,
    show: !data.show
  })
    .then((response) => {
      getProduct()
    })
}

const btnUpdate = (data) => {
  router.push({ name: 'UpdatePage', params: { id: data.id } })
}

const btnImage = (data) => {
  router.push({ name: 'ImagePage', params: { id: data.id } })
}

const btnDelete = (data) => {
  api.delete('deleteProduct/' + data.id)
    .then(() => {
      getProduct()
    }).catch((err) => {
      console.log(err)
    })
}

</script>
