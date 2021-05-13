<template>
    <div class="container">
        <div v-if="player" class="d-flex flex-row mx-auto" style="justify-content: space-between;box-shadow: 0px 0px 13px 0px rgba(0,0,0,0.75);margin-top: 15px;border-radius: 5px;padding: 15px;background-color: #004682">
            <div>
                <img style="width: 50px;border-radius: 5px" :src='skinUrl + player.uuid'>
            </div>
            <p class="player">{{ player.name }}</p>

            <p class="player">{{ player.uuid }}</p>
        </div>
        <div class="actions">
            <button
                class="btn btn-primary add"
                @click="openFormModal"
            >
                <i class="icofont-plus"></i>
            </button>
        </div>
        <div v-if="strafblad.length > 0">
            <div class="d-flex align-items-start mx-auto" style="flex-wrap: wrap; justify-content: space-between;" >
                <div class="wrapped click" @click="openStrafModal(straf.rapport)" style="width: 45%; height: 50px; padding: 15px; background-color: #004682; border-radius: 5px; color: white;margin-top: 5px; margin-bottom: 5px;display: flex; flex-direction: row;box-shadow: 9px 9px 18px -13px rgba(0,0,0,0.75);justify-content: space-between;" v-for="straf in strafblad" v-bind:key="straf.id">
                    <span class="truncate">{{ straf.rapport }}</span><a><i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div v-else>
            <div style="width: 50%; margin: 0 auto; margin-top: 20px; text-align: center;">
                <h4 class="burger_title">Geen straffen gevonden</h4>
            </div>
        </div>
        <div v-if="modal.active">
            <div class="background_modal" @click="closeStrafModal"></div>
            <div class="strafmodal">
                <div class="strafmodel_data">
                    <div class="top_model">
                        <p>Bericht</p>
                        <p style="cursor: pointer;padding: 5px;font-size: 14px;"><i @click="closeStrafModal" class="fas fa-times"></i></p>
                    </div>
                    <div>
                        <p class="modal_message">{{ this.modal.message }}</p>
                    </div>
                    <div class="bottom_model">
                        <button @click="closeStrafModal" class="bottom_button">Sluiten</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="form.active">
            <div class="background_modal" @click="closeFormModal"></div>
            <div class="strafmodal">
                <div class="strafmodel_data">
                    <div class="top_model">
                        <p>Aanmaken van rapport</p>
                        <p style="cursor: pointer;padding: 5px;font-size: 14px;"><i @click="closeFormModal" class="fas fa-times"></i></p>
                    </div>
                    <form style="width: 100%; position: relative;" @submit.prevent="save" @keydown="errors == null">
                        <div style="margin: 10px; width: 100%;" class="rapport">
                            <label>
                                Rapport
                            </label>
                            <textarea 
                                style="width: 95%" 
                                name="rapport" 
                                required
                                id="description"
                                class="form-control"
                                v-model="form.rapport"
                                placeholder
                                type="text"
                                @keyup.enter="save()"
                                @keydown="errors == null"
                            ></textarea>
                            <div v-if="errors" style="color: red;">
                                {{ errors }}
                            </div>
                        </div>
                        <div class="bottom_model">
                            <button type="submit" class="bottom_button">Aanmaken</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    name: 'strafblad-component',
    data() {
        return {
            player: null,
            skinUrl: 'https://crafatar.com/avatars/',
            modal: {
                message: "",
                active: false
            },
            form: {
                rapport: null,
                time: null,
                active: false
            },
            errors: null,          
            start: null,
            end: null,
        }

    },
    props: [
       'strafblad'
    ],
    methods: {
        // table = jailed,
        // id,
        // uuid,
        // date; in milliseconds
        // city
        // inJail
        build() {
            let url = window.location

            axios
                .get(url)
                .then((response) => {
                    this.player = response.data.player;
                })
                .catch(() => {});
        },
        save() {
            axios
                .post('https://meos-opmt.blackmt.nl/add-rapport', { rapport: this.form, player: this.player })
                .then((response) => {
                    this.closeFormModal();
                    window.location.reload();
                })
                .catch(e => {
                    this.errors = e;
                })
        },
        openStrafModal(message = null) {
            this.modal.message = message;

            this.modal.active = true;
        },
        closeStrafModal() {
            this.modal.active = false;
        },
        closeFormModal() {
            this.form.active = false; 
            this.form.rapport = null;
        },
        openFormModal() {
            this.form.active = true;
        }
    },
    mounted() {
        this.build();
    }
}
</script>

<style scoped>
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