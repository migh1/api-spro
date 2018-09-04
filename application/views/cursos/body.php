    <div id="Coaching">
        <section id="services" class="service-item">
           <div class="container">
                <div class="center wow fadeInDown">
                <br /><br />
                    <h2>Cursos - Presenciais e Online</h2>
                    <p class="lead">Agenda de Cursos Presenciais.</p>
                </div>

                <div class="row">
                    <?php if ($this->session->flashdata('sucesso') == 'true'): ?>
                        <?php $this->session->set_flashdata('sucesso', ''); ?>
                        <div class="col-md-12 col-xs-12 wow fadeInDown">
                            <div class="alert alert-success">
                                <strong>Sucesso!</strong> Um email foi enviado com sua solicitação, em breve retornaremos o contato.
                            </div>
                        </div>
                    <?php elseif($this->session->flashdata('sucesso') == 'false'): ?>
                        <?php $this->session->set_flashdata('sucesso', ''); ?>
                        <div class="col-md-12 col-xs-12 wow fadeInDown">
                            <div class="alert alert-danger">
                                <strong>Erro!</strong> Houve um problema ao enviar o email, por favor tente novamente.
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="flip-container col-md-6 col-xs-12 wow fadeInDown" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front card">
                                <img class="img-responsive" src="<?php echo base_url(); ?>assets/images/services/services1.png" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Coaching Profissional</h5>
                                    <p class="card-text">Busca aumentar o desempenho organizacional a partir de um trabalho personalizado, para atender as necessidades de um negócio, de uma área ou de uma equipe.</p>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Agendar Curso</button>
                                </div>
                            </div>
                            <div class="back card">
                                <div class="card-body">
                                    <h5 class="card-title">Matrícula</h5>
                                    <p class="card-text">
                                        Por favor, preencha o formulário abaixo para demonstrar interesse no curso.<br/>
                                        <em>*Entraremos em contato para confirmar seu interesse.</em>
                                    </p>
                                    <form class="form-matricula" action="<?php echo base_url(); ?>index.php/site/formMatricula/0" method="POST">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Nome completo *</label>
                                            <input type="text" name="matricula-nome" class="form-control">
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <label>Email *</label>
                                            <input type="text" name="matricula-email" class="form-control email">
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <label>Telefone *</label>
                                            <input type="text" name="matricula-telefone" class="form-control telefone">
                                        </div>
                                        <div class="col-md-1 col-xs-12"></div>
                                        <div class="col-md-6 col-xs-12">
                                            <label>Horário *</label><br/>
                                            <label class="horario"><input type="radio" name="matricula-horario" value="0"> Manhã</label>
                                            <label class="horario"><input type="radio" name="matricula-horario" value="1"> Tarde</label>
                                            <label class="horario"><input type="radio" name="matricula-horario" value="2"> Noite</label>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Voltar</button>
                                    <button href="#" class="btn btn-success">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1 col-xs-12"></div>

                    <div class="flip-container col-md-6 col-xs-12 wow fadeInDown" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front card">
                                <img class="img-responsive" src="<?php echo base_url(); ?>assets/images/services/services3.png" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Coaching para Empresários</h5>
                                    <p class="card-text">Visa potencializar a performance dos executivos por meio do aumento da eficácia do líder, da capacidade de influenciar, formar, desenvolver e liderar times de alta performance, elevando a motivação, engajamento e produtividade das equipes.</p>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Agendar Curso</button>
                                </div>
                            </div>
                            <div class="back card">
                                <div class="card-body">
                                    <h5 class="card-title">Matrícula</h5>
                                    <p class="card-text">
                                        Por favor, preencha o formulário abaixo para demonstrar interesse no curso.<br/>
                                        <em>*Entraremos em contato para confirmar seu interesse.</em>
                                    </p>
                                    <form class="form-matricula" action="<?php echo base_url(); ?>index.php/site/formMatricula/1" method="POST">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Nome completo *</label>
                                            <input type="text" name="matricula-nome" class="form-control">
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <label>Email *</label>
                                            <input type="text" name="matricula-email" class="form-control email">
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <label>Telefone *</label>
                                            <input type="text" name="matricula-telefone" class="form-control telefone">
                                        </div>
                                        <div class="col-md-1 col-xs-12"></div>
                                        <div class="col-md-6 col-xs-12">
                                            <label>Horário *</label><br/>
                                            <label class="horario"><input type="radio" name="matricula-horario" value="0"> Manhã</label>
                                            <label class="horario"><input type="radio" name="matricula-horario" value="1"> Tarde</label>
                                            <label class="horario"><input type="radio" name="matricula-horario" value="2"> Noite</label>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Voltar</button>
                                    <button href="#" class="btn btn-success">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flip-container col-md-6 col-xs-12 wow fadeInDown" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front card">
                                <img class="img-responsive" src="<?php echo base_url(); ?>assets/images/services/services4.png" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Líder Coach</h5>
                                    <p class="card-text">É um processo de Coaching voltado ao desenvolvimento da liderança de uma ou mais pessoas. Tem como objetivo a melhora no desempenho dos líderes, aumentando o nível de resultados positivos da equipe, da empresa e dos negócios.</p>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Agendar Curso</button>
                                </div>
                            </div>
                            <div class="back card">
                                <div class="card-body">
                                    <h5 class="card-title">Matrícula</h5>
                                    <p class="card-text">
                                        Por favor, preencha o formulário abaixo para demonstrar interesse no curso.<br/>
                                        <em>*Entraremos em contato para confirmar seu interesse.</em>
                                    </p>
                                    <form class="form-matricula" action="<?php echo base_url(); ?>index.php/site/formMatricula/2" method="POST">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Nome completo *</label>
                                            <input type="text" name="matricula-nome" class="form-control">
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <label>Email *</label>
                                            <input type="text" name="matricula-email" class="form-control email">
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <label>Telefone *</label>
                                            <input type="text" name="matricula-telefone" class="form-control telefone">
                                        </div>
                                        <div class="col-md-1 col-xs-12"></div>
                                        <div class="col-md-6 col-xs-12">
                                            <label>Horário *</label><br/>
                                            <label class="horario"><input type="radio" name="matricula-horario" value="0"> Manhã</label>
                                            <label class="horario"><input type="radio" name="matricula-horario" value="1"> Tarde</label>
                                            <label class="horario"><input type="radio" name="matricula-horario" value="2"> Noite</label>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Voltar</button>
                                    <button href="#" class="btn btn-success">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1 col-xs-12"></div>

                   <div class="flip-container col-md-6 col-xs-12 wow fadeInDown" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front card">
                                <img class="img-responsive" src="<?php echo base_url(); ?>assets/images/services/services5.png" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Método IBA - Inteligência Emocional</h5>
                                    <p class="card-text">Ou Coaching de Equipe tem como principal objetivo identificar e desenvolver as competências necessárias para o aumento da produtividade e performance de uma determinada equipe de trabalho.</p>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Agendar Curso</button>
                                </div>
                            </div>
                            <div class="back card">
                                <div class="card-body">
                                    <h5 class="card-title">Matrícula</h5>
                                    <p class="card-text">
                                        Por favor, preencha o formulário abaixo para demonstrar interesse no curso.<br/>
                                        <em>*Entraremos em contato para confirmar seu interesse.</em>
                                    </p>
                                    <form class="form-matricula" action="<?php echo base_url(); ?>index.php/site/formMatricula/3" method="POST">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Nome completo *</label>
                                            <input type="text" name="matricula-nome" class="form-control">
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <label>Email *</label>
                                            <input type="text" name="matricula-email" class="form-control email">
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <label>Telefone *</label>
                                            <input type="text" name="matricula-telefone" class="form-control telefone">
                                        </div>
                                        <div class="col-md-1 col-xs-12"></div>
                                        <div class="col-md-6 col-xs-12">
                                            <label>Horário *</label><br/>
                                            <label class="horario"><input type="radio" name="matricula-horario" value="0"> Manhã</label>
                                            <label class="horario"><input type="radio" name="matricula-horario" value="1"> Tarde</label>
                                            <label class="horario"><input type="radio" name="matricula-horario" value="2"> Noite</label>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Voltar</button>
                                    <button href="#" class="btn btn-success">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!--/.row-->
            </div><!--/.container-->
        </section><!--/#services-->
    </div>
    
