<template>
    <section>
        <div style="width: 50%; justify-content: center; text-align: center; margin-top: 100px;" class="mx-auto">
            <h1 class="burger_title">Burger zoeken</h1>
            <input style="width: 50%; margin-top: 50px;" class="mx-auto burger_input" v-model="search" placeholder="Zoeken" @keyup="onSearchInput" @keydown="clear" onfocus="this.placeholder = ''" onunfocus="this.placeholder = 'Zoeken'">
        </div>
        <div v-if="!loading">
            <div class="d-flex flex-row mx-auto" style="width: 50%;justify-content: space-between;box-shadow: 0px 0px 13px 0px rgba(0,0,0,0.75);margin-top: 15px;border-radius: 5px;padding: 15px;background-color: #004682" v-if="message">
                <p style="height: 45px;">{{ message }}</p>
            </div>
            <div v-if="players">
                <div v-for="player in players" v-bind:key="player.id" style="width: 100%;">

                    <a :href="'/strafblad/burger/'+player.uuid" class="d-flex flex-row mx-auto" style="width: 50%;justify-content: space-between;box-shadow: 0px 0px 13px 0px rgba(0,0,0,0.75);margin-top: 15px;border-radius: 5px;padding: 15px;background-color: #004682">
                        <div v-if="player.uuid">
                            <img style="width: 50px;border-radius: 5px" :src='skinUrl + player.uuid'>
                        </div>
                        <p>{{ player.name }}</p>

                        <p>{{ player.uuid }}</p>
                    </a>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="mx-auto" style="width: 50px;margin-top: 20px">
                 <section id="loading">
                    <div id="loading-content"></div>
                </section>
            </div>
        </div>
    </section>
</template>
<script>
import axios from 'axios';
export default {
    name: 'home-component',
    components: {
        'pagination': require('./helpers/PaginationComponent').default,
    },
    data() {
        return {
            search: "",
            timer: null,
            players: [],
            message: null,
            skinUrl: 'https://crafatar.com/avatars/' ,
            loading: false,
        }
    },
    props: {
    },
    methods: {
        build(refresh = false) {
            this.message = null;
            this.loading = true;
            if (!refresh) {
                this.loading = true;
            }
            let url = `/home/search`;

            if (this.search !== "") {
                url += `?player=${this.search}`;
            }
            if (this.search !== "") {
                axios
                    .post(url)
                    .then((response) => {
                        if(Object.keys(response.data.data).length > 0) {
                            let playerData = response.data.data;
                            this.players = playerData;
                            this.loading = false;
                        } else {
                            this.message = 'Geen burgers gevonden!';
                            this.loading = false;
                        }
                        this.isRequesting = false;
                    })
                    .catch(() => {
                        this.players = null;
                    })
                    .then(() => {
                        this.loading = false;
                    });
            }
        },
        clear() {
            this.players = null;
        },
        onSearchInput() {
            window.clearTimeout(this.timer);
            this.loading = true;
            window.setTimeout(() => {
                this.showLoading();
            }, 10);
            this.timer = window.setTimeout(() => {
                this.hideLoading();
                this.build();
                this.loading = false;
            }, 1000);
        },
        showLoading() {
            document.querySelector('#loading').classList.add('loading');
            document.querySelector('#loading-content').classList.add('loading-content');
        },
        hideLoading() {
            document.querySelector('#loading').classList.remove('loading');
            document.querySelector('#loading-content').classList.remove('loading-content');
        }
    },
    mounted() {
        this.players = null;
        if(this.players == 0) {

        }
    }
}
</script>

<style scoped>
    p {
        line-height: 14px;
        height:20px;
        margin: 0px;
        display: table-cell;
        vertical-align: middle;
        padding: 10px;text-align: left; color: white;margin-top: 5px;
    }
    .loading {
	z-index: 20;
	position: absolute;
	top: 0;
	left: 0px;
	width: 100%;
	height: 100%;
}
.loading-content {
	position: absolute;
	border: 5px solid #f3f3f3; /* Light grey */
	border-top: 5px solid #3498db; /* Blue */
	border-radius: 50%;
	width: 50px;
	height: 50px;
	top: 50%;
	left: calc(50% - 25px);
	animation: spin 2s linear infinite;
	}
	
	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
    .burger_input {
        border: none;
        border-bottom: 2px solid #004682;
        background-color: transparent;
        color: #004682;
        font-size: 23px;
        text-align: center;
    }
    .burger_input:focus {
        outline-width: 0;
        outline: none;
    }
    .burger_title {
        font-family: 'Montserrat', sans-serif;
    }
</style>