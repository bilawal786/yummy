@extends('frontend.layouts.mobile')
@push('extra-style')
    <style>
        .accordion {
            background-color: #ffffff;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active, .accordion:hover {
            background-color: #ffffff;
        }

        .accordion:after {
            content: '\002B';
            color: #777;
            font-weight: bold;
            float: right;
            margin-left: 5px;
        }

        .active:after {
            content: "\2212";
        }

        .panel {
            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }
    </style>
@endpush
@section('main-content')
    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <button class="accordion">Comment fonctionne Yummy Box?</button>
                    <div class="panel">
                        <p>Sur Yummy Box, vous pouvez sauver la nourriture des boulangeries, des primeurs, des supermarchés et de tous nos commerçants partenaires. Au lieu de jeter leurs invendus, nos commerçants composent et proposent des paniers surprise à un prix réduit. C’est simple : trouvez un panier près de chez vous, réservez-le sur l’application et présentez-vous dans le commerce le jour et pendant le créneau horaire indiqué. Une fois sur place, montrez votre reçu pour récupérer votre panier. Félicitations, vous venez de faire un geste anti-gaspi, tout en profitant d’un bon plan !</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">Pourquoi ne pouvez-vous pas me dire ce qu’il y a dans un panier anti-gaspi ?</button>
                    <div class="panel">
                        <p>Les commerçants ne peuvent pas prédire exactement ce qui leur restera à la fin de la journée. Au lieu de jeter de bons produits, ces commerces offrent ce qu’il leur reste sous forme de panier surprise. S’il y en a plus ou moins que prévu, le nombre de paniers proposés sur l’application peut être ajusté. C’est donc toujours une surprise !</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">Pourquoi il n’y a pas de commerce près de chez moi ?</button>
                    <div class="panel">
                        <p>Nous travaillons pour convaincre le maximum de commerçants ! La lutte contre le gaspillage alimentaire n’a pas de limite, n’hésitez pas à revenir sur l’application dans quelque temps. Par ailleurs, vous pouvez nous aider en suggérant des commerces près de chez vous.
                            (<a href="{{route('suggest.business')}}">Suggérer un commerce</a>)
                            Suivez-nous sur les réseaux sociaux pour être au courant des nouveaux commerçants et des nouvelles villes partenaires.
                            (<a href="https://www.facebook.com/YummyBox.fr/">Facebook</a> et <a href="https://instagram.com/yummybox.fr?utm_medium=copy_link">Instagram</a>)</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">Dois-je avoir mon téléphone pour récupérer mon panier.</button>
                    <div class="panel">
                        <p>Oui, il est nécessaire d’avoir votre téléphone pour récupérer votre commande. Arrivé au magasin, vous devrez montrer votre commande au personnel qui la validera directement sur votre téléphone et vous remettra ensuite votre panier surprise.</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">Est-ce que quelqu’un d’autre peut venir récupérer mon panier ?</button>
                    <div class="panel">
                        <p>Pour récupérer votre panier, assurer-vous d’être connecté sur le compte Yummy Box sur lequel la réservation a été effectué. Car, il n’est pas possible d’envoyer votre reçu à quelqu’un d’autre.</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">Est-ce que je peux payer en espèce chez le commerçant ?</button>
                    <div class="panel">
                        <p>Non, tout paiement se fait sur l’application. Ainsi, la collecte est plus facile et plus rapide !
                            Par ailleurs, vous pouvez gagner du temps et de l’argent en rechargeant vos YummyCoin !
                            (<a href="{{route('yummycoin')}}">Recharger mon compte YC</a>)</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">C’est quoi le YummyCoin ?</button>
                    <div class="panel">
                        <p>C’est la monnaie interne de l’application. Soit 1€ = 1000 YC
                            Bénéficiez de nos offres, plus vous rechargez votre compte YummyCoin et moins ils vous coûtent.
                            Exemple : si vous rechargez votre compte de 50€, vous recevrez 56000YC soit 6€ gagnés !
                            Aussi, vous avez la possibilité de gagner des YummyCoin en participant aux actions anti-gaspi menées par nos équipes, en parrainant un ami, en suggérant un commerce ou en suivant notre actualité sur les réseaux sociaux.</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">Comment gagner des YummyCoin avec le parrainage ?</button>
                    <div class="panel">
                        <p>Grâce à votre code de parrainage, vos proches pourront bénéficier de 2000 YC à leur inscription. Pour cela, copiez le code disponible dans le menu « Parrainage » et transférez-le à qui vous le souhaitez.
                            De plus, pour chacun de vos parrainages, vous recevrez également 2000 YC quand votre filleul aura utilisé ses YC gagnés ! </p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">Comment gagner des YummyCoin avec la recommandation de commerçant près de chez vous ?</button>
                    <div class="panel">
                        <p>
                            La recommandation de commerçant est simple et vous rapporte 10000 YC !
                            Pour cela, cliquez sur le menu « suggérer un commerce » et entrez les informations du commerçant. Notre service commercial rentrera en contact avec ce commerçant pour présenter l’application et dès qu’il devient Partenaire Affilié Yummy Box, vous recevez 10000 YC.
                            Par ailleurs, si vous êtes plusieurs à recommander le même commerçant, c’est le premier à avoir envoyé la recommandation qui gagne la mise.</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">Comment annuler ma réservation ?</button>
                    <div class="panel">
                        <p>Vous pouvez annuler une réservation jusqu’à 2 heures avant le début de la collecte en vous rendant directement sur le reçu et en cliquant sur « Annuler la réservation ». Cela laisse suffisamment de temps au panier pour être sauvé par un autre utilisateur.</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">Qui contacter en cas de problème ?</button>
                    <div class="panel">
                        <p>Vous pouvez nous contacter à l’adresse suivante : contact@yummybox.fr
                            Nous faisons le nécessaire pour répondre aux demandes le plus rapidement possible. Veuillez vérifier vos spam car notre réponse peut s’y retrouver.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-js')
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    </script>
@endsection
