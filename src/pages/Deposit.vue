<template>
    <div class="row">
        <div class="col-8">
            <div class="card" style="height: 100%;">
                <div class="card-body">
                    <h1 class="card-title">Einzahlung</h1>
                    <hr>
                    <form style="margin-top: 3em;">
                        <div class="form-group">
                            <label>Betrag</label>
                            <div class="input-group">
                                <input type="text" v-model.number="form.amount" class="form-control" value="1.00" style="text-align: right;">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">€</span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Einzahlen</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card bg-light" style="height: 100%;">
                <div class="card-header">Einzahlung tätigen</div>
                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed omnis, fugiat ipsum quaerat doloribus molestiae autem harum numquam sequi temporibus aliquid exercitationem nam. Alias, at?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed omnis, fugiat ipsum quaerat doloribus molestiae autem harum numquam sequi temporibus aliquid exercitationem nam. Alias, at?</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Deposit',
    data() {
        return {
            form: {
                amount: 0.00,
            },
        };
    },
};
</script>