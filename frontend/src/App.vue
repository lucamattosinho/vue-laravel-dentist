<template>
  <div class="app-container">
    <a-layout>
      <a-layout-header class="header">
        <div class="header-content">
          <div class="logo">Clínica Odonto</div>
          <a-button
            v-if="isLoggedIn"
            type="primary"
            danger
            @click="logout"
          >
            <LogoutOutlined />
            Sair
          </a-button>
        </div>
      </a-layout-header>
      <a-layout-content class="content">
        <!-- Mostrar tabs apenas nas rotas principais -->
        <template v-if="isTabRoute">
          <a-tabs :activeKey="activeTab" @change="onTabChange">
            <a-tab-pane key="consultas" tab="Consultas">
              <Consultas />
            </a-tab-pane>
            <a-tab-pane key="pacientes" tab="Pacientes">
              <Pacientes />
            </a-tab-pane>
          </a-tabs>
        </template>

        <!-- Mostrar outras views (como cadastro) fora das tabs -->
        <template v-else>
          <router-view />
        </template>
      </a-layout-content>
    </a-layout>
  </div>
</template>

<script>
import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { Layout, Tabs, Button, Modal } from 'ant-design-vue';
import { LogoutOutlined } from '@ant-design/icons-vue';
import Consultas from './components/Consultas.vue';
import Pacientes from './components/Pacientes.vue';

export default {
  components: {
    'a-layout': Layout,
    'a-layout-header': Layout.Header,
    'a-layout-content': Layout.Content,
    'a-tabs': Tabs,
    'a-tab-pane': Tabs.TabPane,
    'a-button': Button,
    'a-modal': Modal,
    Consultas,
    Pacientes,
    LogoutOutlined,
  },
  data() {
    return {
      isLoggedIn: false
    };
  },
  mounted() {
    this.checkLogin();
    window.addEventListener('user-logged-in', this.checkLogin);
  },
  beforeUnmount() {
    window.removeEventListener('user-logged-in', this.checkLogin);
  },
  methods: {
    checkLogin() {
      this.isLoggedIn = !!localStorage.getItem('token')
    },
    logout() {
      this.$confirm({
      title: 'Deseja realmente sair?',
      content: 'Você precisará fazer login novamente para acessar o sistema.',
      okText: 'Sim',
      cancelText: 'Cancelar',
      onOk: () => {
        localStorage.removeItem('token');
        this.isLoggedIn = false;
        this.$router.push({ name: 'login' });
      },
      });
    },
  },

  setup() {
    const route = useRoute();
    const router = useRouter();

    const tabRoutes = ['consultas', 'pacientes'];

    const activeTab = computed(() => {
      return tabRoutes.includes(route.name) ? route.name : 'consultas';
    });

    const isTabRoute = computed(() => {
      return tabRoutes.includes(route.name);
    });

    const onTabChange = (key) => {
      router.push({ name: key });
    };

    return {
      activeTab,
      isTabRoute,
      onTabChange,
      LogoutOutlined,
    };
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

:deep(.ant-tabs) {
  width: 100%;
  height: 100%;
  display: flex;
  
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}


</style>

