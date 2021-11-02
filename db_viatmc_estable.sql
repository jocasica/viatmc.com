-- ejecutar 30-10-2021
ALTER TABLE venta ADD COLUMN condicion_pago VARCHAR(50);
ALTER TABLE venta ADD COLUMN credito_con_cuotas TEXT(0);
ALTER TABLE venta ADD COLUMN credito_metodo_pago VARCHAR(50);
ALTER TABLE venta ADD COLUMN credito_fecha DATE;
ALTER TABLE venta ADD COLUMN credito_monto DOUBLE(11, 2);
