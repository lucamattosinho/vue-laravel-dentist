<template>
  <div class="app-container">
    <a-layout>
      <a-layout-header class="header">
        <div class="logo">Clínica Odontooo</div>
      </a-layout-header>
      <a-layout-content class="content">
        <a-tabs v-model:activeKey="activeTab">
          <a-tab-pane key="consultas" tab="Consultas">
            <Consultas />
          </a-tab-pane>
          <a-tab-pane key="pacientes" tab="Pacientes">
            <Pacientes />
          </a-tab-pane>
        </a-tabs>
      </a-layout-content>
    </a-layout>
  </div>
</template>

<script>
import { ref } from 'vue';
import { Layout, Tabs } from 'ant-design-vue';
import Consultas from './components/Consultas.vue';
import Pacientes from './components/Pacientes.vue';

export default {
  components: {
    'a-layout': Layout,
    'a-layout-header': Layout.Header,
    'a-layout-content': Layout.Content,
    'a-tabs': Tabs,
    'a-tab-pane': Tabs.TabPane,
    Consultas,
    Pacientes,
  },
  setup() {
    const activeTab = ref('consultas');
    return { activeTab };
  },
};
</script>

<style scoped>
html, body {
  overflow: hidden;
}

.app-container {
  min-height: 100%;
  width: 100vw;
  display: flex;
  flex-direction: column;
  left: 0;
  padding: 0rem;
  translate: -18.2%;
  overflow: hidden;
}

.header {
  background: #1890ff;
  color: white;
  font-size: 20px;
  padding: 0 24px;
  display: flex;
  align-items: center;
  width: 100%;
}

.logo {
  font-weight: bold;
}

.content {
  flex: 1;
  padding: 24px;
  background: #fff;
  width: 100%;
  display: flex;
  flex-direction: column;
}

:deep(.ant-layout) {
  width: 100%;
  height: 100vh;
}


</style>

