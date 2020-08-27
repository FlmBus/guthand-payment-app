<template>
    <div class="row">
        <div class="col-12">
            <h2>{{ fullName }}</h2>
        </div>
        <div class="col-6">
            <div class="card mb-3">
                <div class="card-body text-center text-white bg-primary">
                    <small class="card-text">Finanzstatus</small><br>
                    <span class="card-title h1">{{ formattedBalance }}</span>
                </div>
                <ul class="list-group list-group-flush">
                    <router-link to="/deposit" class="list-group-item list-group-item-action">Bargeld einzahlen</router-link>
                    <router-link to="/withdraw" class="list-group-item list-group-item-action">Bargeld auszahlen</router-link>
                    <router-link to="/transfer" class="list-group-item list-group-item-action">Überweisung tätigen</router-link>
                </ul>
            </div>
        </div>
        <div class="col-6">
            <ul class="list-group">
                <li class="list-group-item flex-column align-items-start" v-for="trans in transactions">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                            {{ trans.type == 'transfer' ? 'Überweisung' : '' }}
                            {{ trans.type == 'deposit' ? 'Einzahlung' : '' }}
                            {{ trans.type == 'withdrawal' ? 'Auszahlung' : '' }}
                        </h5>
                        <!--<small>{{ trans.created_at.fromNow() }}</small>-->
                        <small>{{ trans.created_at.format('DD. MMMM. YYYY') }}</small>
                    </div>
                    <small class="mb-1" v-if="trans.type == 'transfer'">
                        {{ trans.direction == 'in' ? trans.from.iban : trans.to.iban }}
                    </small>
                    <div v-if="trans.type == 'transfer' && trans.direction == 'in'">{{ trans.from.first_name }} {{ trans.from.last_name }}</div>
                    <div v-if="trans.type == 'transfer' && trans.direction == 'out'">{{ trans.to.first_name }} {{ trans.to.last_name }}</div>
                    <small class="text-success" v-if="trans.direction == 'in'">{{ trans.amount }} €</small>
                    <small class="text-danger" v-if="trans.direction == 'out'">-{{ trans.amount }} €</small>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';

export default {
    name: 'Dashboard',

    data() {
        return {
            user: {
                first_name: '',
                last_name: '',
                iban: '',
            },
            balance: 0,
            transactions: [],
            interval: null,
        };
    },

    mounted() {
        this.fetchStatus();
        this.interval = setInterval(() => {
            this.fetchStatus();
        }, 3000);
    },

    beforeDestroy() {
        if (this.interval !== null) {
            clearInterval(this.interval);
        }
    },

    methods: {
        async fetchStatus() {
            const res = await axios.post('/status');
            if (res.data.success) {
                const data = res.data.data;
                this.balance = data.balance;
                this.user = data.user;
                data.transactions = Object.values(data.transactions);
                data.transactions.forEach(trans => {
                    trans.created_at = moment(trans.created_at);
                    if (trans.from === null) trans.type = 'deposit';
                    if (trans.to === null) trans.type = 'withdrawal';
                    if (trans.from !== null && trans.to !== null) trans.type = 'transfer';
                });
                this.transactions = data.transactions.sort((a, b) => {
                    return  b.created_at - a.created_at;
                });
            }
        },
    },

    computed: {
        formattedBalance() {
            return this.balance + ' €';
        },
        fullName() {
            return `${this.user.first_name} ${this.user.last_name}`;
        }
    },
};
</script>
