package com.alqteam.sc2stats.domain;

import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.OneToMany;
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;

import lombok.EqualsAndHashCode;
import lombok.Getter;
import lombok.Setter;

@Entity
@Table(name="tb_grupo") 
@EqualsAndHashCode(exclude={"listaPlayer"})
public class Grupo {
	
	@Id
	@GeneratedValue
	@Getter @Setter
	@Column(name="id_grupo")
	private Long id;
	
	@Column(name="tx_grupo")
	@Getter @Setter
	private String nome;
	
	@Temporal(TemporalType.TIMESTAMP)
	@Column(name="dt_modify")
	@Getter @Setter
	private Date dtModify;
	
	@Column(name="tx_modify")
	@Getter @Setter
	private String txModify;
	
	@Getter @Setter
	@OneToMany(mappedBy="grupo", fetch = FetchType.LAZY)
	private List<Player> listaPlayer = new ArrayList<Player>();	

}
