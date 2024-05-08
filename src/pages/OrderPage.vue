<template>
  <div class="q-pa-md">
    <h1>Order Page</h1>
    <q-table
      :rows="rows"
      :columns="columns"
      row-key="product_title"
    >
    <template v-slot:body-cell-action="props">
      <q-td :props="props">
        <q-btn-dropdown color="primary">
          <q-list>

            <q-item clickable v-close-popup @click="btnDetail(props.row)">
              <q-item-section>
                <q-item-label>
                  Detail
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
  { name: 'order_number', align: 'center', label: 'Order Number', field: 'order_number' },
  { name: 'date_time', align: 'center', label: 'Date Time', field: 'date_time' },
  { name: 'total_price', align: 'center', label: 'Total Price', field: 'total_price' },
  { name: 'status', align: 'center', label: 'Show/Hide', field: 'status' },
  { name: 'action', align: 'center', field: 'action', label: 'Actions' }
]

const getOrder = () => {
  api.get('getOrder')
    .then((response) => {
      console.log(response.data)
      rows.value = response.data
    }).catch((err) => {
      console.log(err)
    })
}

getOrder()

const btnInsert = () => {
  api.get('checkToken')
    .then(() => {
      router.push({ name: 'InsertOrderPage' })
    }).catch((err) => {
      console.log(err.response.data.messages)
    })
}

const btnDetail = (data) => {
  console.log('detail pushed')
}

const btnDelete = (data) => {
  api.delete('deleteOrder/' + data.id)
    .then(() => {
      getOrder()
    }).catch((err) => {
      console.log(err)
    })
}

</script>
