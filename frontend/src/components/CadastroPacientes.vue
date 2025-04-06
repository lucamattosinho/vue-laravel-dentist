<template>
  <div class="form-container">
    <!-- Botão de Voltar -->
    <a-button type="link" @click="voltar" class="back-button">
      ← Voltar
    </a-button>

    <h2>Cadastrar Paciente</h2>

    <a-form layout="vertical" @submit.prevent="handleSubmit">
      <a-form-item label="Nome">
        <a-input v-model:value="form.first_name" placeholder="João" />
      </a-form-item>

      <a-form-item label="Sobrenome">
        <a-input v-model:value="form.last_name" placeholder="Silva" />
      </a-form-item>

      <div class="form-row">
        <a-form-item label="CPF" class="form-half">
          <a-input v-model:value="form.cpf" placeholder="000.000.000-00" />
        </a-form-item>

        <a-form-item label="Telefone" class="form-half">
          <a-input v-model:value="form.phone" placeholder="(00) 00000-0000" />
        </a-form-item>
      </div>

      <a-form-item>
        <a-button type="primary" html-type="submit" :loading="loading">
          Cadastrar
        </a-button>
      </a-form-item>
    </a-form>

    <a-alert
      v-if="successMessage"
      message="Paciente cadastrado com sucesso!"
      type="success"
      show-icon
      closable
      @close="successMessage = false"
    />
  </div>
</template>

  <script>
  import { ref } from 'vue';
  import { Form, Input, Button, Alert } from 'ant-design-vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  export default {
    components: {
      'a-form': Form,
      'a-form-item': Form.Item,
      'a-input': Input,
      'a-button': Button,
      'a-alert': Alert,
    },
    setup() {
      const form = ref({
        first_name: '',
        last_name: '',
        cpf: '',
        phone: '',
      });
      const router = useRouter();
      const voltar = () => {
        router.back(); // ou: router.push('/pacientes')
      };
      const loading = ref(false);
      const successMessage = ref(false);
  
      const handleSubmit = async () => {
        loading.value = true;
        try {
          await axios.post('http://127.0.0.1:8000/api/pacientes', form.value);
          successMessage.value = true;
          // limpa o formulário
          form.value = {
            first_name: '',
            last_name: '',
            cpf: '',
            phone: '',
          };
        } catch (err) {
          console.error('Erro ao cadastrar paciente:', err);
        } finally {
          loading.value = false;
        }
      };
  
      return {
        form,
        loading,
        handleSubmit,
        successMessage,
        voltar,
      };
    },
  };
  </script>

<style scoped>
.form-container {
  max-width: 1800px;
  min-width: 800px;
  margin: 0 auto;
  padding: 2rem;
  background: #fff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  border-radius: 12px;
}

.form-row {
  display: flex;
  gap: 1rem;
}

.form-half {
  flex: 1;
}

.back-button {
  padding-left: 0;
  margin-bottom: 1rem;
  font-weight: bold;
}


</style>
  