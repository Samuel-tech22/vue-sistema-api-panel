<template>
    <AppLayout>
      <div class="p-6">
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold">Clientes</h1>
          <Link 
            :href="route('clients.create')" 
            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 dark:bg-blue-700 border border-transparent rounded-md hover:bg-blue-700 dark:hover:bg-blue-800"
          >
            Nuevo Cliente
          </Link>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow dark:shadow-zinc-800 p-6">
          <div class="flex items-center gap-4 mb-6">
            <div class="flex-1">
              <Input
                v-model="search"
                type="text"
                placeholder="Buscar..."
              />
            </div>
			<div class="w-40">
				<Select
				v-model="statusFilter"
				width="w-40"
				>
				<option value="">Todos</option>
				<option value="active">Activos</option>
				<option value="inactive">Inactivos</option>
				</Select>
			</div>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
              <thead class="bg-gray-50 dark:bg-zinc-800">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nombre</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Documento</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estado</th>
                  <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                <tr v-for="client in filteredClients" :key="client.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900 dark:text-gray-300">{{ client.name }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 dark:text-gray-300">{{ client.email }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 dark:text-gray-300">{{ client.document }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="{
                      'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                      'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': client.status === 'active',
                      'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300': client.status === 'inactive'
                    }">
                      {{ client.status === 'active' ? 'Activo' : 'Inactivo' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <Link
                      :href="route('clients.edit', client.id)"
                      class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-2"
                    >
                      Editar
                    </Link>
                    <button
                      @click="deleteClient(client.id)"
                      class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                    >
                      Eliminar
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <Pagination :links="props.clients.links" />
        </div>
      </div>
    </AppLayout>
  </template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import Pagination from '@/components/Pagination.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import Input from '@/components/ui/input/Input.vue'
import Select from '@/components/ui/select/Select.vue'

const props = defineProps({
  clients: {
    type: Object,
    required: true
  }
})

const search = ref('')
const statusFilter = ref('')

const filteredClients = computed(() => {
  if (!props.clients?.data) return []
  
  return props.clients.data.filter((client: any) => {
    const matchesSearch = client.name.toLowerCase().includes(search.value.toLowerCase()) ||
                         client.email.toLowerCase().includes(search.value.toLowerCase()) ||
                         client.document.includes(search.value)
    const matchesStatus = !statusFilter.value || client.status === statusFilter.value
    return matchesSearch && matchesStatus
  })
})

const deleteClient = (id: string) => {
  if (confirm('¿Estás seguro de que deseas eliminar este cliente?')) {
    router.delete(route('clients.destroy', id))
  }
}
</script>
