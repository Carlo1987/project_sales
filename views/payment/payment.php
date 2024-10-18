<h2>Scegli il metodo di pagamento</h2>

<div class="message_payment">
    Essendo questo un progetto, il pagamento sarà simulato! <br class="space_payment">
    Scegli quindi il pagamento che preferisci inserendo dei dati fittizzi
</div>

<div class="content_payment">

    <div class="chose_payment">
        <div class="title_card">Carta di debito</div>
        <div class="title_bank">Accredito bancario</div>
    </div>

    <form class="payment card_debit" method="POST" action="<?= url('send-payment') ?>">
        <div class="methods_payments">
            <p class="type_cards">Carte accettate :</p>
            <article> <img src="<?= url('assets/img/payment/Visa-Logo.png') ?>" alt="image_card"> </article>
            <article> <img src="<?= url('assets/img/payment/mastercard_logo.png') ?>" alt="image_card"> </article>
            <article> <img src="<?= url('assets/img/payment/maestro_logo.png') ?>" alt="image_card"> </article>
            <article> <img src="<?= url('assets/img/payment/carta_credito.png') ?>" alt="image_card"> </article>
        </div>

        <div>
            <label for="name">Nome titolare:</label>
            <input type="text" name="name">
        </div>

        <div>
            <label for="surname">Cognome titolare:</label>
            <input type="text" name="surname">
        </div>

        <div>
            <label for="code">Numero carta:</label>
            <input type="number"  placeholder="numero carta di 16 caratteri senza spazi" name="code">
        </div>

        <div class="expiration_cards">
            <p style="width: 33.5%;">
                Scadenza:
            </p>
         
                <select class="month" name="month">
                    <?php for ($i = 1; $i <= 12; $i++) :
                        if ($i < 10) {
                            $i = '0' . strval($i);
                        } ?>
                        <option value="<?= $i ?>"> <?= $i ?> </option>
                    <?php endfor;  ?>
                </select>
           
                <select class="year" name="year">
                    <?php $year = date('Y');
                    for ($x = $year; $x <= ($year + 10); $x++) :  ?>
                        <option value="<?= $x ?>"> <?= $x ?> </option>
                    <?php endfor; ?>
                </select>
           
        </div>

            <div>
                <label for="security">Codice di controllo:</label>
                <input type="number" maxlength="3" placeholder="codice di 3 caratteri" name="security">
            </div>

        <input type="submit" class="buy" value="Pagamento" name="card">

    </form>

    <form class="payment bank" method="POST" action="<?= url('send-payment') ?>">
 
            <div>
                <label for="bic">BIC:</label>
                <input type="text" placeholder="codice BIC dagli 8 ai 11 caratteri, non obbligatorio" name="bic">
            </div>
       
            <div>
                <label for="iban">IBAN:</label>
                <input type="text" placeholder="IT 74 M 12345 12345 00000000 4923" name="iban">
            </div>

            <div>
                <label for="name">Nome titolare del conto:</label>
                <input type="text" placeholder="nome e cognome" name="dates">
            </div>
 
        <input type="submit" class="buy" value="Pagamento" name="bank">
    </form>
    
</div>