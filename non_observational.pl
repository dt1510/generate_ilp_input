dynamic woman/1, female/1, man/1, male/1, couple/2.

modeh(man(+person)).
modeh(woman(+person)).
modeb(male(+person)).
modeb(female(+person)).

determination(woman/1, female/1).
determination(man/1, male/1).

%type information
person(bob).
person(rob).
person(mary).
person(susan).

%background knowledge
male(bob).
male(rob).
female(mary).
female(susan).

%positive examples
couple(bob, mary).
couple(bob, susan).
couple(rob, susan).
couple(rob, mary).

%negative examples
couple(bob, rob).
couple(mary, susan).
couple(susan, bob).

