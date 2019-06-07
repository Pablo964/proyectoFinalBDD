create function busqPartido (p_anyo_mundial varchar2, p_local varchar2, p_visitante varchar2, p_estadio varchar2,
  devolver_partido out estructura_sintipo)
  is
    goles number;
    orden number;
    cantidadGoles varchar2(100);
    PonerTitulo EQUIPOS.EQUIPO%type;
    cad varchar2(100);
    cantidad number;
    i partido%rowtype;
  begin
    
    open devolver_partido for select *
                                from partido
                                where (p_anyo_mundial is null or to_char(fecha,'yyyy')=p_anyo_mundial)
                                  and (p_local is null or equipo_l=p_local)
                                  and (p_visitante is null or equipo_v=p_visitante)
                                  and (p_estadio is null or sede=p_estadio)
                                  ORDER BY fecha;

                    
    select count(*)
     into cantidad
     from partido
    where (p_anyo_mundial is null or to_char(fecha,'yyyy')=p_anyo_mundial)
      and (p_local is null or equipo_l=p_local)
      and (p_visitante is null or equipo_v=p_visitante)
      and (p_estadio is null or sede=p_estadio);
    dbms_output.put_line(cantidad);
    IF cantidad  < 4 then
        loop
            fetch devolver_partido into i;
            exit when devolver_partido%notfound;



            insert into TMP_ESTRUCTURA
            (origen_datos, c1,c2,c3,n1,n2,n3,c6)
            values
            ('PARTIDO', i.equipo_l, i.equipo_v, i.fecha, i.resultado_l, i.resultado_v,-1,null);

            --dbms_output.put_line(i.EQUIPO_L);
            --dbms_output.put_line('----------------');
            PonerTitulo:=i.EQUIPO_L;
            for equipoLocal in (select *
                        from jugar, jugador
                        where EQUIPO_L_PART=i.EQUIPO_L
                        and EQUIPO_V_PART=i.EQUIPO_v
                        and FECHA_PART=i.fecha
                        and nombre_jug=nombre
                        and equipo_l_part=EQUIPO_jugador
                        order by dorsal)
            loop
                select count(*)
                 into goles
                 from gol
                where JUGADOR_GOL=equipoLocal.nombre_jug
                  and EQUIPO_L_GOL=equipoLocal.equipo_l_part
                  and EQUIPO_V_GOL=equipoLocal.equipo_v_part
                  and FECHA_GOL=equipoLocal.fecha_part;
                if goles=0 then
                    cantidadGoles:=' ';
                else
                    cantidadGoles:=lpad('*',goles,'*');
                end if;
                insert into TMP_ESTRUCTURA
                (origen_datos, c1,c2,c3,n1,n2,n3,c4,n4,c5,c6)
                values
                ('EQUIPO L', i.equipo_l, i.equipo_v, i.fecha, i.resultado_l, i.resultado_v, equipoLocal.dorsal, equipoLocal.nombre_jug, equipoLocal.min_jugar, cantidadGoles,PonerTitulo);
                PonerTitulo:=' ';
            end loop;
--            dbms_output.put_line(i.EQUIPO_V);
--            dbms_output.put_line('----------------');
            PonerTitulo:=i.EQUIPO_V;
            for equipoVisitante in (select *
                        from jugar, jugador
                        where EQUIPO_L_PART=i.EQUIPO_L
                        and EQUIPO_V_PART=i.EQUIPO_v
                        and FECHA_PART=i.fecha
                        and nombre_jug=nombre
                        and equipo_v_part=EQUIPO_jugador
                        order by dorsal)
            loop
--                dbms_output.put(equipoLocal.dorsal||'- '||equipoLocal.nombre_jug||' ('||equipoLocal.min_jugar||') ');
                select count(*)
                 into goles
                 from gol
                where JUGADOR_GOL=equipoVisitante.nombre_jug
                  and EQUIPO_L_GOL=equipoVisitante.equipo_l_part
                  and EQUIPO_V_GOL=equipoVisitante.equipo_v_part
                  and FECHA_GOL=equipoVisitante.fecha_part;
                if goles=0 then
                    cantidadGoles:=' ';
                else
                    cantidadGoles:=lpad('*',goles,'*');
                end if;
                insert into TMP_ESTRUCTURA
                (origen_datos, c1,c2,c3,n1,n2,n3,c4,n4,c5,c6)
                values
                ('EQUIPO V', i.equipo_l, i.equipo_v, i.fecha, i.resultado_l, i.resultado_v, equipoVisitante.dorsal, equipoVisitante.nombre_jug, equipoVisitante.min_jugar, cantidadGoles,PonerTitulo);
                PonerTitulo:=' ';
                       
            end loop;
        
        end loop;
        close devolver_partido;

        open devolver_partido for select * from TMP_ESTRUCTURA; -- MACHACO EL CURSOR DE SALIDA A DEVOLVER
    ELSIF cantidad <11 THEN                              
        loop
            fetch devolver_partido into i;
            exit when devolver_partido%notfound;
            insert into TMP_ESTRUCTURA
            (origen_datos,c1,c2,c3,n1,n2,n3,c4,c5,n4)
            values
            ('PARTIDO', i.equipo_l, i.equipo_v, i.fecha, i.resultado_l, i.resultado_v, i.asistencia, i.hora, i.sede,-1);
            for goles in (select gol.*, equipo_jugador
                        from gol, jugador
                        where EQUIPO_L_GOL=i.equipo_l
                         and EQUIPO_V_GOL=i.equipo_v
                         and FECHA_GOL=i.fecha
                         and jugador_gol=nombre
                         order by minuto)
                        loop
                            insert into TMP_ESTRUCTURA
                            (origen_datos,c1,c2,c3,n1,n2,n3,c4,n4,c6, c7)
                                values
                            ('GOLES',i.equipo_l, i.equipo_v, i.fecha, i.resultado_l, i.resultado_v, i.asistencia, i.sede,goles.minuto, goles.jugador_gol, goles.equipo_jugador);
                        end loop;
        end loop;
        close devolver_partido;

        open devolver_partido for select * from TMP_ESTRUCTURA; -- MACHACO EL CURSOR DE SALIDA A DEVOLVER
    end if;
    
    return cantidad;
    
  end busqPartido;