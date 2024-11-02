<!DOCTYPE html>
<html>
<head>
    <title>Consenso alla Pubblicazione dei Riscontri e delle Testimonianze</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" media="screen" href="feedback.css">
</head>
<body style="padding: 0 20px;">
    <div class="container" style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
    <h1 style="font-size: 1.2rem; font-weight: bold;">Consenso alla Pubblicazione dei Riscontri e delle Testimonianze</h1>
    <p style="text-align:left; font-size: 0.8rem;">Il/La Sottoscritto/a <span style="font-weight: bold;">{{ $first_name ?? 'Mario' }} {{ $last_name ?? 'Rossi' }}</span>, fornisce i suoi dati personali, utilizzati esclusivamente per identificarlo/a e per gestire i consensi relativi alla privacy e alla pubblicazione di riscontri, testimonianze e feedback (tramite anonimato, dunque preservando i suoi dati sensibili).</p>
    </div>
    <div class="container" style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <h2 style="font-size: 1rem; font-weight: bold; text-align:left;">Acconsente alla condivisione di riscontri, testimonianze e feedback - da Lei espressi/e privatamente - sul lavoro svolto dalla sottoscritta in suo favore e sull'attività che essa gestisce?</h2>
        <p style="text-align:left; font-size: 0.8rem;">I suoi dati personali, sensibili (quali nome, cognome, numero di telefono, codice fiscale, indirizzo ed e-mail), saranno sempre mantenuti anonimi, ma alcuni estratti delle nostre conversazioni verranno resi pubblici con l'intento di facilitare la comprensione generale verso certe prestazioni olistiche. Oltre a chiarire la natura dei servizi, i suoi riscontri aiuteranno a confermare l'efficacia delle pratiche proposte, fornendo utili indicazioni a chiunque sia interessato a richiedere un servizio simile, sia per curiosità che per necessità.</p>
        <div style="display: flex; flex-direction: row; justify-content: space-between; width: 100%;">
            <p style="text-align: left; margin: 0;">
                <label style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox"
                           @if($first_consent === 1) checked @endif
                           style="margin: 0; width: 16px; height: 16px;">
                    @if($first_consent === 1)
                        <span style="font-weight: bold;">Acconsento</span>
                    @else
                        <span>Acconsento</span>
                    @endif
                </label>
            </p>
            <p style="text-align: left; margin: 0;">
                <label style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox"
                           @if($first_consent === 0) checked @endif
                           style="margin: 0; width: 16px; height: 16px;">
                    @if($first_consent === 0)
                        <span style="font-weight: bold;">Non acconsento</span>
                    @else
                        <span>Non acconsento</span>
                    @endif
                </label>
            </p>
        </div>
    </div>
    <div class="container" style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <h2 style="font-size: 1rem; font-weight: bold; text-align:left;">Conferma di essere pienamente in grado di intendere e volere e di accettare i termini riguardanti la condivisione di estratti delle conversazioni?</h2>
        <p style="text-align:left; font-size: 0.8rem;">Confermando quanto soprascritto, dichiara di possedere la piena capacità di intendere e volere e di accettare la condivisione di estratti delle nostre conversazioni a fini informativi, mantenendo l'anonimato dei suoi dati personali. Dando conferma riconosce altresì che, in qualsiasi momento e senza necessità di motivazione, ha il diritto di richiedere la cancellazione di tali estratti, in conformità con il suo diritto alla privacy.</p>
        <div style="display: flex; flex-direction: row; justify-content: space-between; width: 100%;">
            <p style="text-align: left; margin: 0;">
                <label style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox"
                           @if($second_consent === 1) checked @endif
                           style="margin: 0; width: 16px; height: 16px;">
                    @if($second_consent === 1)
                        <span style="font-weight: bold;">Acconsento</span>
                    @else
                        <span>Acconsento</span>
                    @endif
                </label>
            </p>
            <p style="text-align: left; margin: 0;">
                <label style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox"
                           @if($second_consent === 0) checked @endif
                           style="margin: 0; width: 16px; height: 16px;">
                    @if($second_consent === 0)
                        <span style="font-weight: bold;">Non acconsento</span>
                    @else
                        <span>Non acconsento</span>
                    @endif
                </label>
            </p>
        </div>
    </div>
    <div class="container" style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <h2 style="font-size: 1rem; font-weight: bold; text-align:left;">Conferma che i consensi forniti o negati nei precedenti moduli sono legati ai dati personali da Lei inseriti all'inizio?</h2>
        <p style="text-align:left; font-size: 0.8rem;">Per garantire la corretta gestione dei suoi consensi relativi alla privacy e alla condivisione di riscontri, testimonianze e feedback, le viene chiesto di confermare che i dati personali inseriti nel primo modulo compilato siano veritieri ed identificativi della sua persona, così da poterli utilizzare in maniera coerente per collegare tutti i consensi espressi o negati nei moduli successivi. Suddetta procedura ci aiuterà a rispettare i suoi diritti alla privacy e a gestire in modo sicuro e trasparente le sue informazioni.</p>
        <div style="display: flex; flex-direction: row; justify-content: space-between; width: 100%;">
            <p style="text-align: left; margin: 0;">
                <label style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox"
                           @if($third_consent === 1) checked @endif
                           style="margin: 0; width: 16px; height: 16px;">
                    @if($third_consent === 1)
                        <span style="font-weight: bold;">Acconsento</span>
                    @else
                        <span>Acconsento</span>
                    @endif
                </label>
            </p>
            <p style="text-align: left; margin: 0;">
                <label style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox"
                           @if($third_consent === 0) checked @endif
                           style="margin: 0; width: 16px; height: 16px;">
                    @if($third_consent === 0)
                        <span style="font-weight: bold;">Non acconsento</span>
                    @else
                        <span>Non acconsento</span>
                    @endif
                </label>
            </p>
        </div>
    </div>
    <div class="container" style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <p style="text-align:left; font-weight: bold;">Data e ora di invio: {{ \Carbon\Carbon::parse($submit_date)->timezone('Europe/Rome')->format('d-m-Y H:i:s') }}</p>
        <p style="text-align:left; font-size: 0.8rem;">Per qualsiasi dubbio o esigenza in riferimento a questo modulo, invito il/la cliente a contattarmi privatamente. Idem in caso vi sia un eventuale cambio di idea rispetto la pubblicazione dei riscontri e le precedenti attestazioni qui presenti. Lascio di seguito i miei contatti principali.</p>
        <p style="text-align:left; font-weight: bold;">Cellulare:
            <span style="font-weight: normal;">+39 351 3054419</span>
        </p>
        <p style="text-align:left; font-weight: bold;">Email:
            <span style="font-weight: normal;">info@rominafabi.it</span>
        </p>
    </div>
</body>
</html>
