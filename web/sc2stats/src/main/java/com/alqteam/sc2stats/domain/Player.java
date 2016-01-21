package com.alqteam.sc2stats.domain;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.Table;

import lombok.Getter;
import lombok.Setter;


@Entity
@Table(name="tb_player")
public class Player {
	@Id
	@GeneratedValue
	@Getter @Setter
	@Column(name="id_player")
	private Long id;
	
	@Getter @Setter
	@Column(name="tx_player")	
	private String player;
	
	@Getter @Setter
	@ManyToOne
	@JoinColumn(name="id_grupo")	
	private Grupo grupo;
	
	@Getter @Setter
	@Column(name="tx_perfil")
	private String perfil;
	
	@Getter @Setter
	@Column(name="tx_nome")	
	private String nome;
	
	@Getter @Setter
	@Column(name="portraitX")
	private Integer portraitX;
	
	@Getter @Setter
	@Column(name="portraitY")	
	private Integer portraitY;	
	
	@Getter @Setter
	@Column(name="achievementPoints")
	private Integer achievementPoints;
	
	@Getter @Setter
	@Column (name="totalCareerGames")
	private Integer totalCareerGames;	
	
	@Getter @Setter
	@Column (name="oldGames")
	private Integer oldGames;
	
	@Getter @Setter
	@Column(name="highestSolo_times")
	private Integer highestSoloTimes;
	
	@Getter @Setter
	@Column(name="highestSolo_league")	
	private String highestSoloLeague;
	
	@Getter @Setter
	@Column(name="highestTeam_times")
	private Integer highestTeamTimes;
	
	@Getter @Setter
	@Column(name="highestTeam_league")
	private String highestTeamLeague;
	
	@Getter @Setter
	@Column(name="cs_ativo")
	private Integer ativo;
	
	@Getter @Setter
	@Column(name="portraitUrl")	
	private String portraitUrl;
	
	@Getter @Setter
	@Column(name="swarmLevel")
	private Integer swarmLevel;
	
	@Getter @Setter
	@Column(name="actualLeague")	
	private String actualLeague;
	
	@Getter @Setter
	@Column(name="ia_wins")
	private Integer iaWins;
	
	@Getter @Setter
	@Column(name="ia_loss")
	private Integer iaLoss;

	
}
