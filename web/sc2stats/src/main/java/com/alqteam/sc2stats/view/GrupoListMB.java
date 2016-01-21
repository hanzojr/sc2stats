package com.alqteam.sc2stats.view;

import java.util.Iterator;
import java.util.List;
import javax.inject.Inject;
import br.gov.frameworkdemoiselle.annotation.NextView;
import br.gov.frameworkdemoiselle.annotation.PreviousView;
import br.gov.frameworkdemoiselle.stereotype.ViewController;
import br.gov.frameworkdemoiselle.template.AbstractListPageBean;
import br.gov.frameworkdemoiselle.transaction.Transactional;
import com.alqteam.sc2stats.business.GrupoBC;
import com.alqteam.sc2stats.domain.Grupo;

@ViewController
@NextView("./grupo_edit.jsf")
@PreviousView("./grupo_list.jsf")
public class GrupoListMB extends AbstractListPageBean<Grupo, Long> {

	private static final long serialVersionUID = 1L;

	@Inject
	private GrupoBC grupoBC;
	
	@Override
	protected List<Grupo> handleResultList() {
		return this.grupoBC.findAll();
	}
	
	@Transactional
	public String deleteSelection() {
		boolean delete;
		for (Iterator<Long> iter = getSelection().keySet().iterator(); iter.hasNext();) {
			Long id = iter.next();
			delete = getSelection().get(id);
			if (delete) {
				grupoBC.delete(id);
				iter.remove();
			}
		}
		return getPreviousView();
	}

}