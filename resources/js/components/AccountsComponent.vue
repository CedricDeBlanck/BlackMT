<template>
    <section class="container">
        <div v-for="user in userdata" :key="user.id" >
            <div v-if="user.name != 'admin'">
                <div class="d-flex flex-row mx-auto" style="justify-content: space-between;box-shadow: 0px 0px 13px 0px rgba(0,0,0,0.75);margin-top: 15px;border-radius: 5px;padding: 15px;background-color: #004682;color: white;">
                    <p class="player">{{ user.name }}</p>
                    <p class="player">{{ user.email }}</p>
                    <p class="player">{{ user.role }}</p>
                    <div class="actions">
                        <button class="action" @click="openEditModal(user)">
                            <i class="icofont-pencil-alt-5"></i>
                        </button>
                        <form method="POST" action="/delete-user">
                            <input type="hidden" value="user">
                            <button class="action delete" type="submit">
                                <i class="icofont-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="form.active">
            <div class="background_modal" @click="closeEditModal"></div>
            <div class="strafmodal">
                <div class="strafmodel_data">
                    <div class="top_model">
                        <p>Wijzigen van gebruiker</p>
                        <p style="cursor: pointer;padding: 5px;font-size: 14px;"><i @click="closeEditModal" class="fas fa-times"></i></p>
                    </div>
                    <form style="width: 100%; position: relative;" action="/save-user" @keydown="errors == null">
                        <div style="margin: 10px; width: 100%;" class="rapport">
                            <label>
                                Naam
                            </label>
                            <input 
                                style="width: 95%" 
                                name="name" 
                                id="name"
                                class="form-control"
                                v-model="form.name"
                                placeholder
                                type="text"
                                @keyup.enter="save()"
                                @keydown="errors == null"
                                defaultValue="form.user.name"
                            >
                            <label>
                                E-mail
                            </label>
                            <input
                                style="width: 95%"
                                name="email"
                                id="email"
                                class="form-control"
                                v-model="form.email"
                                placeholder="example@blackmt.nl"
                            >
                            <label>
                                Functie
                            </label>
                            <select name="role" id="role" class="form-control" v-model="form.role" style="width: 95%">
                                <option>Aspirant</option>
                                <option>Agent</option>
                                <option>Hoofd Agent</option>
                                <option>Rechercheur</option>
                                <option>Brigadier</option>
                                <option>Korpschef</option>
                                <option>DSI</option>
                                <option>Directie Justitie</option>
                                <option>Staatssecretaris</option>
                                <option>Minister</option>
                            </select>
                            <div v-if="errors" style="color: red;">
                                {{ errors }}
                            </div>
                        </div>
                        <div class="bottom_model">
                            <button type="submit" class="bottom_button">Wijzigen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import axios from 'axios';
export default {
    props: [
        
    ],
    data() {
        return {
            userdata: [],
            player: null,
            form: {
                user: null,
                active: false,
                name: null,
                email: null,
                role: null
            },
            errors: null
        }
    },
    props: [
        'allusers'
    ],
    methods: {
        build() {
            this.userdata = JSON.parse(this.allusers);
        },
        openEditModal(user) {
            this.form.active = true;
            this.form.user = user;
        },
        closeEditModal() {
            this.form.active = false;
        },
        deleteUser() {
            axios
                .post(route('accounts.delete'), { user: this.user })
        }
    },
    mounted() {
        this.build();
    }
}
</script>
<style scoped>
    button.action {
        color: white;
        border: none;
        background-color: transparent;
    }
    button.action:hover {
        color: lightgrey;
    }
    button.action.delete:hover {
        color: red;
    }
        .click {
        cursor: pointer;
    }
    .player {
        line-height: 14px;
        height: 20px;
        margin: 0px;
        display: table-cell;
        vertical-align: middle;
        padding: 10px;
        text-align: left; 
        color: white;
        margin-top: 5px;
    }
    .wrapped{
        display: inline-block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        word-wrap: break-word;
    }
    .strafmodal {
        position: absolute;
        width: 450px;
        height: auto;
        border-radius: 5px;
        background: white;
        border: 1px solid gray;
        top: 25%;
        left: calc(50% - 212.5px);
        z-index: 999;
        color: #004682;
    }
    .background_modal {
        background-color: gray;
        opacity: 0.5;
        position: absolute;
        width: 100vw;
        height: 100vh;
        top: 0;
        left: 0;
    }
    .modal_message {
        padding: 15px;
        font-size: 18px;
    }
    .strafmodel_data {
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .top_model {
        top: 0;
        left: 0;
        width: 100%;
        height: 40px;
        background-color: rgb(238, 241, 246);
        font-family: 'Montserrat', sans-serif;
        text-transform: uppercase;
        font-size: 14px;
        padding: 10px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        color: rgb(115, 120, 117);
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        border-bottom: 0.5px solid gainsboro;
    }

    .truncate {
        display: inline-block;
        width: 275px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .truncate + a {
        display: inline-block;
        vertical-align: top;
        margin-top: -1px;
    }
    .truncate + a i {
       padding: 5px;
    }
    .bottom_model {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        background-color: rgb(238, 241, 246);
        bottom: 0px;
        left: 0px;
        width: 100%;
        height: auto;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        border-top: 0.5px solid gainsboro;
    }
    .bottom_button {
        background-color: #004682;
        color: white;
        font-family: 'Montserrat', sans-serif;
        font-size: 15px;
        text-transform: uppercase;
        border: none;
        border-radius: 5px;
        margin: 15px;
        padding: 5px;
        padding-left: 10px;
        padding-right: 10px;
        float: right;
        font-weight: 400;
    }
    .burger_title {
        font-family: 'Montserrat', sans-serif;
    }
</style>