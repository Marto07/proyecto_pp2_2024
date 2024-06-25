USE proyecto_pp2;

SELECT id_perfil, descripcion_perfil, descripcion_modulo 
FROM 
asignacion_perfil_modulo apm
JOIN 
perfil p 
ON 
p.id_perfil = apm.rela_perfil 
JOIN 
modulo m 
ON 
apm.rela_modulo = m.id_modulo 
WHERE 
rela_perfil = 3;