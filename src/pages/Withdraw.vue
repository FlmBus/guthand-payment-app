<template>
    <div class="row">
        <div class="col-8">
            <div class="card" style="height: 100%;">
                <div class="card-body">
                    <h1 class="card-title">Auszahlung</h1>
                    <hr>
                    <div class="alert alert-danger" role="alert" v-if="error">
                        {{ error }}
                    </div>
                    <form style="margin-top: 3em;" @submit.prevent="onSubmit">
                        <div class="form-group">
                            <label>Betrag</label>
                            <div class="input-group">
                                <input type="text" v-model.number="form.amount" class="form-control" value="1.00" style="text-align: right;">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">€</span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Auszahlen</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card bg-light" style="height: 100%;">
                <div class="card-header">Auszahlung tätigen</div>
                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed omnis, fugiat ipsum quaerat doloribus molestiae autem harum numquam sequi temporibus aliquid exercitationem nam. Alias, at?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed omnis, fugiat ipsum quaerat doloribus molestiae autem harum numquam sequi temporibus aliquid exercitationem nam. Alias, at?</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Withdraw',
    data() {
        return {
            form: {
                amount: 0.00,
            },
            error: null,
        };
    },
    methods: {
        async onSubmit() {
            try {
                const res = await axios.post('/withdraw', {
                    amount: this.form.amount,
                });
                if (!res.data.success && res.data.errors) {
                    for (const err of res.data.errors) {
                        throw new Error(err);
                    }
                }
                this.$router.push('dashboard');
            } catch (err) {
                this.error = err;
            }
        },
    },
};
</script>