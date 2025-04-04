<template>
    <div>
      <h2>Pacientes</h2>
      <a-list bordered :data-source="pacientes">
        <template #renderItem="{ item }">
          <a-list-item>
            {{ item.nome }}
          </a-list-item>
        </template>
      </a-list>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import { List } from 'ant-design-vue';
  
  export default {
    components: {
      'a-list': List,
      'a-list-item': List.Item,
    },
    setup() {
      const pacientes = ref([
        { id: 1, nome: 'Maria Silva' },
        { id: 2, nome: 'João Souza' },
      ]);
  
      return { pacientes };
    },
  };
  </script>
  