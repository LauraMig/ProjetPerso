<?php
include("headerun.php")
;?>
    <title>Remède animale connexion</title>


    <main class="mesure-page-co">
        <form class="formulaireco">
            <h1 class="titreformco"> Connectez-vous </h1>
            <hr class="traitco">

            <div class="corps-formulaireco">
                <div class="gaucheco">
                    <div class="groupeco">
                        <label class="label-infoco">Votre-email</label>
                        <input class="input-infoco" id="input_connection" type="email" placeholder="Inserez-email" required>
                    </div>
                    <div class="groupeco">
                        <label class="label-infoco">Votre mot de passe </label>
                        <input class="input-infoco" id="input_connect" type="password" placeholder="Inserez votre mot de passe"
                            pattern="[A-Za-z0-9_$]{8,}" required="required">

                        <div class="groupeco">

                            <button class="boutonco">Envoyer le message</button>
                        </div>
                    </div>
                </div>
            </div>




        </form>
    </main>
    <?php
include("footer.php")
;?>
