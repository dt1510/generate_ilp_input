%toplog, test

:-modeh(woman(+person)).
:-modeb(female(+person)).
:-modeb(male(+person)).


%type information
person(adam).
person(bob).
person(alice).
person(mary).

%background knowledge
male(adam).
male(bob).
female(alice).
female(mary).
female(susan).

%positive examples
example(woman(alice),1).
example(woman(mary),1).
example(woman(susan),1).

%negative examples
example(woman(adam),-1).

