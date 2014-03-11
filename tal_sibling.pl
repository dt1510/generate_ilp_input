%tal, sibling
:- multifile option/2.
option(max_body_literals, 2).
option(score_before_condition, false).
option(max_num_rules, 2).
option(single_seed, false).
option(strategy, full_breadth).
option(max_depth, 200).
:-dynamic brother/2, parent/2.

modeh(brother(+person,+person)).
modeh(parent(+person,+person)).
modeb(sibling(+person)).
modeb(male(+person)).
modeb(father(+person)).


%type information
person(X).

%background knowledge
male(bart).
male(rod).
male(todd).
parent(homer,bart).
parent(homer,maggie).
father(ned,rod).
father(ned,todd).
father(homer,lisa).
sibling(X,Y):-parent(Z,X),parent(Z,Y).

%positive examples
example(brother(bart,lisa),1).
example(brother(rod,todd),1).

%negative examples
example(brother(lisa,bart),-1).
example(brother(rod,bart),-1).
example(parent(lisa,bart),-1).


