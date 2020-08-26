<template>
    <div class="row">
        <div class="col-8">
            <div class="card" style="height: 100%;">
                <div class="card-body">
                    <h1 class="card-title">Überweisung</h1>
                    <hr>
                    <form style="margin-top: 3em;">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-8">
                                    <label>IBAN des Empfängers</label>
                                    <input type="text" v-model.trim="form.iban" class="form-control">
                                    <small class="form-text text-muted">Bitte vergewissern sie sich, dass die IBAN korrekt ist.</small>
                                </div>
                                <div class="col-4">
                                    <label>Betrag</label>
                                    <div class="input-group mb-3">
                                        <input type="text" v-model.number="form.amount" class="form-control" value="1.00" style="text-align: right;">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">€</span>
                                        </div>
                                        <small class="form-text text-danger">Ungenügender Kontostand.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Verwendungszweck</label>
                            <textarea class="form-control" v-model.trim="form.message" rows="3"></textarea>
                            <small class="form-text text-danger">Bitte ausschließlich Zahlen, Buchstaben, Unterstriche und bindestriche verwenden.</small>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Senden</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card bg-light" style="height: 100%;">
                <div class="card-header">Überweisung tätigen</div>
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
    name: 'Transfer',
    data() {
        return {
            form: {
                iban: '',
                amount: 0.00,
                message: '',
            },
        };
    },
};
</script>