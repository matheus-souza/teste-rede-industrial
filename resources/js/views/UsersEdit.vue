<template>
    <div>
        <div v-if="!loaded">Loading...</div>
        <form @submit.prevent="onSubmit($event)" class="col-6 mt-3">
            <div class="form-group">
                <label for="user_name">Nome</label>
                <input id="user_name" v-model="user.name" class="form-control" placeholder="Seu nome" required/>
            </div>
            <div class="form-group">
                <label for="user_email">E-mail</label>
                <input id="user_email" type="email" v-model="user.email" class="form-control" placeholder="Seu e-mail" required/>
            </div>
            <div class="form-group">
                <label for="user_telefone">Telefone</label>
                <the-mask :mask="['(##) #####-####']" id="user_telefone" type="phone" v-model="user.telefone" class="form-control" required/>
            </div>
            <div class="form-group">
                <button type="submit" :disabled="saving" class="btn btn-secondary">Update</button>
                <button :disabled="saving" @click.prevent="onDelete($event)" type="button" class="btn btn-danger">Delete</button>
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
                loaded: false,
                saving: false,
                user: {
                    id: null,
                    name: "",
                    email: "",
                    telefone: ""
                }
            };
        },
        methods: {
            onSubmit(event) {
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

                api.update(this.user.id, {
                    name: this.user.name,
                    email: this.user.email,
                    telefone: this.user.telefone,
                }).then((response) => {
                    Swal.fire({
                        position: 'top',
                        type: 'success',
                        title: 'Usuário salvo!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.$router.push({ name: 'users.index' });
                }).catch(error => {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Erro ao salvar o usuário!',
                        footer: error.message
                    });
                }).then(_ => this.saving = false);
            },
            onDelete() {
                this.saving = true;

                Swal.fire({
                    title: 'Você tem certeza?',
                    text: "Você não poderá reverter isso!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, exclua-o!',
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.value) {
                        api.delete(this.user.id)
                            .then((response) => {
                                Swal.fire(
                                    'Deletado!',
                                    'Usuário foi deletado.',
                                    'success'
                                );
                                this.$router.push({ name: 'users.index' });
                            });
                    }
                }).finally(_ => {
                    this.saving = false;
                });
            }
        },
        created() {
            api.find(this.$route.params.id)
                .then((response) => {
                    this.loaded = true;
                    this.user = response.data.data;
                }).catch((err) => {
                    this.$router.push({ name: '404' });
                });
        }
    };
</script>
