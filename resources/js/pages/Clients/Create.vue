<template>
  <Head :title="isEdit ? 'Editar Cliente' : 'Nuevo Cliente'" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">{{ isEdit ? 'Editar Cliente' : 'Nuevo Cliente' }}</h1>

      <div class="bg-white dark:bg-zinc-900 rounded-lg shadow dark:shadow-zinc-800 p-6">
        <form @submit.prevent="submit">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nombre -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
              <Input 
                v-model="form.name" 
                type="text" />
              <div v-if="form.errors.name" class="text-sm text-red-600 dark:text-red-400">{{ form.errors.name }}</div>
            </div>

            <!-- Email -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
              <Input 
                v-model="form.email" 
                type="email" />
              <div v-if="form.errors.email" class="text-sm text-red-600 dark:text-red-400">{{ form.errors.email }}</div>
            </div>

            <!-- Documento -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Documento</label>
              <Input 
                v-model="form.document" 
                type="text" />
              <div v-if="form.errors.document" class="text-sm text-red-600 dark:text-red-400">{{ form.errors.document }}</div>
            </div>

            <!-- Teléfono -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
              <Input 
                v-model="form.phone" 
                type="text" />
              <div v-if="form.errors.phone" class="text-sm text-red-600 dark:text-red-400">{{ form.errors.phone }}</div>
            </div>

            <!-- Dirección -->
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dirección</label>
              <Input 
                v-model="form.address" 
                type="text" />
              <div v-if="form.errors.address" class="text-sm text-red-600 dark:text-red-400">{{ form.errors.address }}</div>
            </div>

            <!-- Ciudad y Estado -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ciudad</label>
              <Input 
                v-model="form.city" 
                type="text" />
              <div v-if="form.errors.city" class="text-sm text-red-600 dark:text-red-400">{{ form.errors.city }}</div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
              <Input 
                v-model="form.state" 
                type="text" />
              <div v-if="form.errors.state" class="text-sm text-red-600 dark:text-red-400">{{ form.errors.state }}</div>
            </div>

            <!-- Código Postal -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código Postal</label>
              <Input 
                v-model="form.postal_code" 
                type="text" />
              <div v-if="form.errors.postal_code" class="text-sm text-red-600 dark:text-red-400">{{ form.errors.postal_code }}</div>
            </div>

            <!-- Estado -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
              <Select v-model="form.status">
                <option value="active">Activo</option>
                <option value="inactive">Inactivo</option>
              </Select>
              <div v-if="form.errors.status" class="text-sm text-red-600 dark:text-red-400">{{ form.errors.status }}</div>
            </div>
          </div>

          <div class="mt-6 flex justify-end space-x-4">
            <Link :href="route('clients.index')" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-700">Cancelar</Link>
            <button type="submit" 
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 dark:bg-blue-700 border border-transparent rounded-md hover:bg-blue-700 dark:hover:bg-blue-800">
              {{ isEdit ? 'Actualizar' : 'Crear' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { computed, watch } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { type BreadcrumbItem } from '@/types'
import Input from '@/components/ui/input/Input.vue'
import Select from '@/components/ui/select/Select.vue'

const props = defineProps({
  client: Object
})

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Clientes',
    href: route('clients.index')
  },
  {
    title: props.client ? 'Editar Cliente' : 'Nuevo Cliente',
    href: props.client ? route('clients.edit', props.client.id) : route('clients.create')
  }
]

const isEdit = computed(() => !!props.client)

const form = useForm({
  name: props.client?.name || '',
  email: props.client?.email || '',
  document: props.client?.document || '',
  phone: props.client?.phone || '',
  address: props.client?.address || '',
  city: props.client?.city || '',
  state: props.client?.state || '',
  postal_code: props.client?.postal_code || '',
  status: props.client?.status || 'active'
})

const submit = () => {
  if (isEdit.value) {
    form.put(route('clients.update', props.client?.id))
  } else {
    form.post(route('clients.store'))
  }
}

// Resetear el formulario cuando se reciba un nuevo cliente
watch(() => props.client, (newClient) => {
  if (newClient) {
    form.reset(
      'name',
      'email',
      'document',
      'phone',
      'address',
      'city',
      'state',
      'postal_code',
      'status'
    )
  }
})
</script>
