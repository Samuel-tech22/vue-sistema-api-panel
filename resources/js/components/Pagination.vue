<template>
  <nav v-if="links.length > 3" class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
    <div class="flex justify-between flex-1 sm:hidden">
      <a
        v-if="links[0].url"
        :href="links[0].url"
        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
      >
        Anterior
      </a>
      <a
        v-if="links[links.length - 1].url"
        :href="links[links.length - 1].url"
        class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
      >
        Siguiente
      </a>
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Mostrando
          <span class="font-medium">{{ from }}</span>
          hasta
          <span class="font-medium">{{ to }}</span>
          de
          <span class="font-medium">{{ total }}</span>
          resultados
        </p>
      </div>
      <div>
        <nav class="inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
          <a
            v-for="(link, key) in links"
            :key="key"
            :href="link.url"
            :class="{
              'relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50': link.label === 'Previous',
              'relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50': link.label === 'Next',
              'relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50': link.label !== 'Previous' && link.label !== 'Next' && !link.active,
              'relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-indigo-600 hover:bg-indigo-700': link.active,
              'hidden': !link.url && link.label !== 'Previous' && link.label !== 'Next'
            }"
          >
            <span v-html="link.label" />
          </a>
        </nav>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps({
  links: {
    type: Array,
    required: true
  }
})

const from = computed(() => {
  if (!props.links[1]?.url) return 0
  return props.links[1].label * 15 - 14
})

const to = computed(() => {
  if (!props.links[1]?.url) return 0
  return props.links[1].label * 15
})

const total = computed(() => {
  return props.links[props.links.length - 2]?.label * 15
})
</script>
