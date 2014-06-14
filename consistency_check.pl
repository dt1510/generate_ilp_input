dynamic woman/1, female/1.

modeh(woman(+person)).
modeb(female(+person)).

determination(woman/1, female/1).

%type information
person(jane).

%background knowledge
female(jane).
:-female(jane).

%positive examples
woman(jane).
woman(susan).
woman(mary).

%negative examples

