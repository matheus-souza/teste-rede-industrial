<template>
    <div>
        <h2 class="col-6 mt-3 mb-3">Criar usuário</h2>

        <form @submit.prevent="onSubmit($event)" class="col-6">
            <div class="form-group">
                <label for="user_name">Name</label>
                <input id="user_name" v-model="user.name" class="form-control" placeholder="Seu nome" required/>
            </div>
            <div class="form-group">
                <label for="user_email">Email</label>
                <input id="user_email" type="email" v-model="user.email" class="form-control" placeholder="Seu e-mail" required/>
            </div>
            <div class="form-group">
                <label for="user_telefone">Telefone</label>
                <the-mask :mask="['(##) #####-####']" id="user_telefone" type="phone" v-model="user.telefone" class="form-control" required/>
            </div>

            <div class="form-group">
                <button type="submit" :disabled="saving" class="btn btn-secondary">
                    {{ saving ? 'Criando usuário...' : 'Criar usuário' }}
                </button>
            </div>
        </form>
    </div>
</template>
<script>
    import api from '../api/users';
    import Swal from 'sweetalert2';

    export default {
        data() {
            return {
                saving: false,
                user: {
                    name: '',
                    email: '',
                    telefone: '',
                }
            }
        },
        methods: {
            onSubmit($event) {
                this.saving = true;

                if (this.user.telefone.length < 11) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Preencha o campo de telefone corretamente!'
                    });

                    this.saving = false;
                    return;
                }

                api.create(this.user)
                    .then((response) => {
                    Swal.fire({
                        position: 'top',
                        type: 'success',
                        title: 'Usuário salvo!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.$router.push({ name: 'users.edit', params: { id: response.data.data.id } });
                }).catch(error => {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Erro ao salvar o usuário!',
                        footer: error.message
                    });
                }).then(_ => this.saving = false);
            }
        }
    }
</script>
