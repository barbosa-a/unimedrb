<?php

    function contratoSistemas($conn)
    {
        // listar dados do contrato
        $cons_contrato = "SELECT * FROM contrato_sistema ORDER BY razao_social ASC";
        $query_cons_contrato = mysqli_query($conn, $cons_contrato);
        //$contrato = mysqli_fetch_assoc($query_cons_contrato);
        return $query_cons_contrato;
    }