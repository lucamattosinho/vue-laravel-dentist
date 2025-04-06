<template>
    <a-row justify="center" style="height: 100vh">
      <a-col :span="8">
        <a-card title="Login" bordered>
          <a-form
            :model="form"
            :rules="rules"
            ref="loginForm"
            layout="vertical"
            @finish="onFinish"
          >
            <a-form-item label="Email" name="email">
              <a-input v-model:value="form.email" placeholder="Digite seu email" />
            </a-form-item>
  
            <a-form-item label="Senha" name="password">
              <a-input-password v-model:value="form.password" placeholder="Digite sua senha" />
            </a-form-item>
  
            <a-form-item>
              <a-button type="primary" html-type="submit" block :loading="loading">Entrar</a-button>
            </a-form-item>
          </a-form>
        </a-card>
      </a-col>
    </a-row>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          email: '',
          password: '',
        },
        loading: false,
        rules: {
          email: [
            { required: true, message: 'Digite seu email', trigger: 'blur' },
            { type: 'email', message: 'Email inválido', trigger: 'blur' },
          ],
          password: [
            { required: true, message: 'Digite sua senha', trigger: 'blur' },
            { min: 6, message: 'Senha deve ter pelo menos 6 caracteres', trigger: 'blur' },
          ],
        },
      };
    },
    methods: {
      async onFinish() {
        this.loading = true;
        try {
          const response = await fetch('http://localhost:8000/api/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
              email: this.form.email,
              password: this.form.password,
            }),
          });
        
          if (response.ok) {
            const data = await response.json();
            localStorage.setItem('token', data.access_token);
            window.dispatchEvent(new Event('user-logged-in')); // <--- ESSENCIAL
            this.$router.push({ name: 'consultas' });
          } else {
            this.$message.error('Email ou senha inválidos');
          }
        } catch (error) {
          this.$message.error('Erro ao tentar fazer login');
          console.error(error);
        } finally {
          this.loading = false;
        }
      },
    },
  };
  </script>
  